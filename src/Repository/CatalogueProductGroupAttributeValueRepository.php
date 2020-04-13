<?php

namespace App\Repository;

use App\Entity\CatalogueProductGroupAttributeValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CatalogueProductGroupAttributeValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatalogueProductGroupAttributeValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatalogueProductGroupAttributeValue[]    findAll()
 * @method CatalogueProductGroupAttributeValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogueProductGroupAttributeValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatalogueProductGroupAttributeValue::class);
    }

    // /**
    //  * @return CatalogueProductGroupAttributeValue[] Returns an array of CatalogueProductGroupAttributeValue objects
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
    public function findOneBySomeField($value): ?CatalogueProductGroupAttributeValue
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
