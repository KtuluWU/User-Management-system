<?php

namespace App\Repository;

use App\Entity\PurchaseHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PurchaseHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchaseHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchaseHistory[]    findAll()
 * @method PurchaseHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PurchaseHistory::class);
    }

//    /**
//     * @return PurchaseHistory[] Returns an array of PurchaseHistory objects
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
    public function findOneBySomeField($value): ?PurchaseHistory
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
