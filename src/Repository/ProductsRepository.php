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

        /**
         * @return Products[] Returns an array of Expansions objects
         */
        public function findByMetaCardOrderByExpansionName(int $idMetaCard) : array
        {
            return $this->createQueryBuilder('p')
                ->select('p, e, s')
                ->leftJoin('p.expansion', 'e')
                ->leftJoin('p.scryfall', 's')
                ->where('p.idMetaCard = :idMetaCard')
                ->setParameter('idMetaCard', $idMetaCard)
                ->orderBy('e.name', 'ASC')
                ->getQuery()
                ->getResult();
        }
        
        /**
         * @return Products[] Returns an array of Products objects
         */
        public function findByExpansionWithRelations(int $expansionId, string $sortBy="collector_number"): array
        {
            // Récupérer les IDs dans l'ordre souhaité avec SQL natif
            $conn = $this->getEntityManager()->getConnection();

            switch ($sortBy) {
                case 'name_asc':
                    $orderBy = 'p.name ASC';
                    break;
                case 'name_desc':
                    $orderBy = 'p.name DESC';
                    break;
                case 'collector_number':
                default:
                    $orderBy = "
                        CAST(COALESCE(s.collector_number, '9999') AS UNSIGNED) ASC,
                        s.collector_number ASC,
                        p.name ASC
                    ";
                    break;
            }
            
            $sql = "
                SELECT p.id
                FROM products p
                LEFT JOIN expansions e ON p.idExpansion = e.id
                LEFT JOIN scryfall_products s ON s.card_market_id_id = p.id
                WHERE e.id = :expansionId
                ORDER BY 
                    $orderBy
            ";
            
            $stmt = $conn->prepare($sql);
            $result = $stmt->executeQuery(['expansionId' => $expansionId]);
            $productIds = array_column($result->fetchAllAssociative(), 'id');
            
            if (empty($productIds)) {
                return [];
            }
            
            // Récupérer les objets Products avec leurs relations
            $products = $this->createQueryBuilder('p')
                ->leftJoin('p.expansion', 'e')
                ->addSelect('e')
                ->leftJoin('p.scryfall', 's')
                ->addSelect('s')
                ->where('p.id IN (:productIds)')
                ->setParameter('productIds', $productIds)
                ->getQuery()
                ->getResult();
            
            // Réorganiser selon l'ordre SQL
            $orderedProducts = [];
            $productsById = [];
            
            foreach ($products as $product) {
                $productsById[$product->getId()] = $product;
            }
            
            foreach ($productIds as $id) {
                if (isset($productsById[$id])) {
                    $orderedProducts[] = $productsById[$id];
                }
            }
            
            return $orderedProducts;
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
