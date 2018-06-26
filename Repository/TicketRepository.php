<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Util\Inflector;
use Maps_red\TicketingBundle\Model\TicketInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class TicketRepository
 * @package Maps_red\TicketingBundle\Repository
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
     * @throws \Doctrine\ORM\NonUniqueResultException
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
            $qb->andWhere('q.author = :author');
            $parameters['author'] = $user;
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
}