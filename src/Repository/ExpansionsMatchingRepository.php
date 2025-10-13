<?php

namespace App\Repository;

use App\Entity\ExpansionsMatching;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpansionsMatching>
 */
class ExpansionsMatchingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpansionsMatching::class);
    }

        /**
         * @return ExpansionsMatching[] Returns an array of ExpansionsMatching objects
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
         * @return ExpansionsMatching[] Returns an array of ExpansionsMatching objects
         */
        public function getAllMatchingIcons()
        {
            $data = $this->createQueryBuilder('e')
                ->select('e, s')
                ->leftJoin('e.scryfallExpansion', 's')
                ->where('s.iconSvgUri IS NOT NULL')
                ->getQuery()
                ->getResult();

            $result = [];

            foreach ($data as $row) {
                if( array_key_exists( $row->getcardMarketExpansionId()->getId(), $result ) ) continue;

                $result[$row->getcardMarketExpansionId()->getId()] = $row->getScryfallExpansion()->getIconSvgUri();
            }

            return $result;
        }

        
    //    /**
    //     * @return ExpansionsMatching[] Returns an array of ExpansionsMatching objects
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
