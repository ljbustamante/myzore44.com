<?php

namespace App\Repository;

use App\Entity\ProductGroupAttributeValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductGroupAttributeValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductGroupAttributeValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductGroupAttributeValue[]    findAll()
 * @method ProductGroupAttributeValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductGroupAttributeValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductGroupAttributeValue::class);
    }

    // /**
    //  * @return ProductGroupAttributeValue[] Returns an array of ProductGroupAttributeValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductGroupAttributeValue
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
