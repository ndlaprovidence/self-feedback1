<?php

namespace App\Repository;

use App\Entity\StudentCritere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StudentCritere|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentCritere|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentCritere[]    findAll()
 * @method StudentCritere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentCritereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentCritere::class);
    }

    // /**
    //  * @return StudentCritere[] Returns an array of StudentCritere objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StudentCritere
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
