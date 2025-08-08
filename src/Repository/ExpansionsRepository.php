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
        
    //    /**
    //     * @return Expansions[] Returns an array of Expansions objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Expansions
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
