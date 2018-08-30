<?php

namespace App\Repository;

use App\Entity\UsersInfos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UsersInfos|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersInfos|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersInfos[]    findAll()
 * @method UsersInfos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersInfosRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UsersInfos::class);
    }

//    /**
//     * @return UsersInfos[] Returns an array of UsersInfos objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsersInfos
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
