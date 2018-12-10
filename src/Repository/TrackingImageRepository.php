<?php

namespace App\Repository;

use App\Entity\TrackingImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrackingImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrackingImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrackingImage[]    findAll()
 * @method TrackingImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrackingImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrackingImage::class);
    }

//    /**
//     * @return TrackingImage[] Returns an array of TrackingImage objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrackingImage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
