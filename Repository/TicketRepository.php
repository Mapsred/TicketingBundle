<?php

namespace Maps_red\TicketingBundle\Repository;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\User\UserInterface;

class TicketRepository extends ServiceEntityRepository
{
    public function searchDataTable(string $globalSearch = null, array $columns, array $fields, array $sortOrder, int $offset,
                                    int $limit, bool $isCount, $status, $type, UserInterface $user = null)
    {
        $parameters = ['status' => $status];
        $joins = ['q.status' => 'status'];
        $qb = $this->createQueryBuilder('q')
            ->where('status.name = :status');

        $sort = key($sortOrder);
        $order = $sortOrder[$sort];
        $joins = $this->searchOrder($qb, $sort, $order, $joins);


        if ($type === 'perso') {
            $qb->andWhere('q.author = :author');
            $parameters['author'] = $user;
        }

        if (null !== $globalSearch) {
            $qbWhere = [];
            $parameters['globalSearch'] = '%' . $globalSearch . '%';

            foreach ($fields as $field) {
                $field = Inflector::camelize($field);
                $qbWhere[] = $qb->expr()->like('q.' . $field, ':globalSearch');
            }

            $qb->andWhere(call_user_func_array([$qb->expr(), 'orX'], $qbWhere));
        } elseif (!empty($columns)) {
            $qbWhere = [];
            foreach ($columns as $field => $value) {
                if ($field === 'author') {
                    $joins['q.author'] = 'author';
                    $qbWhere[] = $qb->expr()->like('author.username', ':' . $field);
                } elseif ($field === 'category') {
                    $joins['q.category'] = 'category';
                    $qbWhere[] = $qb->expr()->like('category.name', ':' . $field);
                } elseif ($field === 'status') {
                    $qbWhere[] = $qb->expr()->like('status.value', ':' . $field);
                } else {
                    $field = Inflector::camelize($field);
                    $qbWhere[] = $qb->expr()->like('q.' . $field, ':' . $field);
                }

                $parameters[$field] = '%' . $value . '%';
            }

            $qb->andWhere(call_user_func_array([$qb->expr(), 'andX'], $qbWhere));
        }

        foreach ($joins as $join => $alias) {
            $qb->leftJoin($join, $alias);
        }

        $qb->setParameters($parameters);

        if ($isCount) {
            return $qb->select('COUNT(q.id)')->getQuery()->getSingleScalarResult();
        }

        return $qb->setFirstResult($offset)->setMaxResults($limit)->getQuery()->getResult();

    }

    /**
     * @param QueryBuilder $qb
     * @param string $sort
     * @param string $order
     * @param array $joins
     * @return array
     */
    private function searchOrder(QueryBuilder $qb, string $sort, string $order, array $joins)
    {
        if ($sort === 'author') {
            $joins['q.author'] = 'author';
            $qb->orderBy('author.username.', $order);
        } elseif ($sort === 'category') {
            $joins['q.category'] = 'category';
            $qb->orderBy('category.name.', $order);
        } elseif ($sort === 'status') {
            $joins['q.status'] = 'status';
            $qb->orderBy('status.value.', $order);
        } else {
            $qb->orderBy('q.' . Inflector::camelize($sort), $order);
        }

        return $joins;
    }
}