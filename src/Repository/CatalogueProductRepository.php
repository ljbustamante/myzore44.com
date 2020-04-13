<?php

namespace App\Repository;

use App\Entity\CatalogueProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CatalogueProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatalogueProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatalogueProduct[]    findAll()
 * @method CatalogueProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogueProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatalogueProduct::class);
    }

    // /**
    //  * @return CatalogueProduct[] Returns an array of CatalogueProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CatalogueProduct
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
