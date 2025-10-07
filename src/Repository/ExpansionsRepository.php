<?php

namespace App\Repository;

use App\Entity\Expansions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expansions>
 */
class ExpansionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expansions::class);
    }

        /**
         * @return Expansions[] Returns an array of Expansions objects
         */
        public function findByName($value): array
        {
            return $this->createQueryBuilder('e')
                ->andWhere('e.name LIKE :val')
                ->setParameter('val', "%".$value."%")
                ->orderBy('e.name', 'ASC')
                ->getQuery()
                ->getResult()
            ;

        }

        /**
         * Find recent expansions with their card count
         * 
         * @param int $limit
         * @return array
         */
        public function findRecentExpansionsWithCardCount(int $limit = 6): array
        {
            return $this->createQueryBuilder('e')
                ->select('e.id, e.name, COUNT(p.id) as cardCount')
                ->leftJoin('App\Entity\Products', 'p', 'WITH', 'p.expansion = e.id')
                ->groupBy('e.id, e.name')
                ->orderBy('e.id', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult()
            ;
        }
}
