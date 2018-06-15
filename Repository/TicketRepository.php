<?php
/**
 * Created by PhpStorm.
 * User: fma
 * Date: 15/06/18
 * Time: 14:57
 */

namespace Maps_red\TicketingBundle\Repository;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Util\Inflector;

class TicketRepository extends ServiceEntityRepository
{
    public function searchDataTable(string $globalSearch = null, array $columns, array $fields, array $sort, int $offset,
                                    int $limit, bool $isCount, $status, $type)
    {
        $parameters = [];
        $qb = $this->createQueryBuilder('q')
            ->orderBy('q.' . Inflector::camelize(key($sort)), $sort[key($sort)]);

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
                    $qb->leftJoin('q.author', 'author');
                    $qbWhere[] = $qb->expr()->like('author.username', ':' . $field);
                } elseif ($field === 'category') {
                    $qb->leftJoin('q.category', 'category');
                    $qbWhere[] = $qb->expr()->like('category.name', ':' . $field);
                } elseif ($field === 'status') {
                    $qb->leftJoin('q.status', 'status');
                    $qbWhere[] = $qb->expr()->like('status.value', ':' . $field);
                } else {
                    $field = Inflector::camelize($field);
                    $qbWhere[] = $qb->expr()->like('q.' . $field, ':' . $field);
                }

                $parameters[$field] = '%' . $value . '%';
            }

            $qb->andWhere(call_user_func_array([$qb->expr(), 'andX'], $qbWhere));
        }

        $qb->setParameters($parameters);

        if ($isCount) {
            return $qb->select('COUNT(q.id)')->getQuery()->getSingleScalarResult();
        }

        return $qb->setFirstResult($offset)->setMaxResults($limit)->getQuery()->getResult();

    }
}