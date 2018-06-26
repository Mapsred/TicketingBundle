<?php

namespace Maps_red\TicketingBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class TicketCategoryRepository extends ServiceEntityRepository
{
    /**
     * @return array
     */
    public function findAllCategories()
    {
        $result = $this->createQueryBuilder('q')
            ->select("q.name")
            ->orderBy("q.position", "ASC")
            ->getQuery()
            ->getResult();

        $response = [];
        foreach ($result as $item) {
            $response[] = $item['name'];
        }

        return $response;
    }
}
