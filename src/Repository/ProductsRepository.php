<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

        /**
         * @return Products[] Returns an array of Expansions objects
         */
        public function findByNameUnique($value): array
        {
            return $this->createQueryBuilder('c')
                    ->select('MIN(c.id) as id, c.name')
                    ->andWhere('c.name LIKE :val')
                    ->setParameter('val', "%".$value."%")
                    ->groupBy('c.name')
                    ->orderBy('c.name', 'ASC')
                    ->getQuery()
                    ->getResult();

        }


        /**
         * @return Products[] Returns an array of Expansions objects
         */
        public function findUnique(): array
        {
            return $this->createQueryBuilder('c')
                    ->select('MIN(c.id) as id, c.name')
                    ->groupBy('c.name')
                    ->orderBy('c.name', 'ASC')
                    ->getQuery()
                    ->getResult();

        }

        public function findByMetaCardOrderByExpansionName(int $idMetaCard) : array
        {
            return $this->createQueryBuilder('p')
                ->leftJoin('p.expansion', 'e')
                ->where('p.idMetaCard = :idMetaCard')
                ->setParameter('idMetaCard', $idMetaCard)
                ->orderBy('e.name', 'ASC')
                ->getQuery()
                ->getResult();
        }

    //    /**
    //     * @return Products[] Returns an array of Products objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Products
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
