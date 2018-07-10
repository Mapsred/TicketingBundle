<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Util\Inflector;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method TicketInterface|object|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketInterface|object|null findOneBy(array $criteria, array $orderBy = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    /** @var array $joins */
    private $joins;

    /**
     * @param string|null $globalSearch
     * @param array $columns
     * @param array $fields
     * @param array $sortOrder
     * @param int $offset
     * @param int $limit
     * @param bool $isCount
     * @param string $status
     * @param string $type
     * @param UserInterface|null $user
     * @return array|int
     */
    public function searchDataTable(string $globalSearch = null, array $columns, array $fields, array $sortOrder, int $offset,
                                    int $limit, bool $isCount, $status, $type, UserInterface $user = null)
    {
        $this->joins = ['q.status' => 'status'];
        $parameters = ['_status' => $status];
        $qb = $this->createQueryBuilder('q')
            ->where('status.name = :_status');

        $sort = key($sortOrder);
        $order = $sortOrder[$sort];
        $qb->orderBy($this->getX($sort), $order);

        if ($type === 'perso') {
            $qb->andWhere('q.author = :_author');
            $parameters['_author'] = $user;
        }

        if ($type === 'list_public') {
            $qb->andWhere($qb->expr()->orX('q.author = :_author', 'q.public = :_public'));

            $parameters['_author'] = $user;
            $parameters['_public'] = true;
        }

        if (null !== $globalSearch) {
            $qbWhere = [];
            $parameters['globalSearch'] = '%' . $globalSearch . '%';

            foreach ($fields as $field) {
                $qbWhere[] = $qb->expr()->like($this->getX($field), ':globalSearch');
            }

            $qb->andWhere(call_user_func_array([$qb->expr(), 'orX'], $qbWhere));
        } elseif (!empty($columns)) {
            $qbWhere = [];
            foreach ($columns as $field => $value) {
                $qbWhere[] = $qb->expr()->like($this->getX($field), ':' . $field);
                $parameters[$field] = '%' . $value . '%';
            }

            $qb->andWhere(call_user_func_array([$qb->expr(), 'andX'], $qbWhere));
        }

        foreach ($this->joins as $join => $alias) {
            $qb->leftJoin($join, $alias);
        }

        $qb->setParameters($parameters);

        if ($isCount) {
            return $qb->select('COUNT(q.id)')->getQuery()->getSingleScalarResult();
        }

        return $qb->setFirstResult($offset)->setMaxResults($limit)->getQuery()->getResult();
    }

    /**
     * @param string $field
     * @return string
     */
    private function getX(string $field)
    {
        if ($field === 'author') {
            $this->joins['q.author'] = 'author';

            return 'author.username';
        } elseif ($field === 'category') {
            $this->joins['q.category'] = 'category';

            return 'category.name';
        } elseif ($field === 'status') {
            $this->joins['q.status'] = 'status';

            return 'status.value';
        } elseif ($field === 'priority') {
            $this->joins['q.priority'] = 'priority';

            return 'priority.value';
        } elseif ($field === 'assignated') {
            $this->joins['q.assignated'] = 'assignated';

            return 'assignated.username';
        }

        return 'q.' . Inflector::camelize($field);
    }

    /**
     * @param UserInterface $user
     * @return float|int
     */
    public function findUserAvgRating(UserInterface $user)
    {
        $results = [];
        /** @var TicketInterface[] $tickets */
        $tickets = $this->createQueryBuilder('q')
            ->where('q.assignated = :user')
            ->andWhere("q.rating IS NOT NULL")
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        foreach ($tickets as $ticket) {
            $results[] = $ticket->getRating();
        }

        $avg = count($results) > 0 ? array_sum($results) / count($results) : 0;

        return $avg;
    }

    /**
     * @param UserInterface $user
     * @param $status
     * @return int
     */
    public function countBySpecificUserAndStatus(UserInterface $user, $status)
    {
        $result = $this->createQueryBuilder('q')
            ->leftJoin("q.assignated", "user")
            ->leftJoin("q.status", "status")
            ->select('user.username assignated, COUNT(q) nb')
            ->where("status.name = :status")
            ->andWhere("q.assignated = :user")
            ->groupBy("assignated")
            ->orderBy("q.id", "DESC")
            ->setParameters(["status" => $status, "user" => $user])
            ->getQuery()
            ->getOneOrNullResult();

        return isset($result) ? $result['nb'] : 0;
    }

}