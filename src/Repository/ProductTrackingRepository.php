<?php

namespace App\Repository;

use App\Entity\ProductTracking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductTracking|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductTracking|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductTracking[]    findAll()
 * @method ProductTracking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductTrackingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductTracking::class);
    }

//    /**
//     * @return ProductTracking[] Returns an array of ProductTracking objects
//     */
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
    public function findOneBySomeField($value): ?ProductTracking
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
