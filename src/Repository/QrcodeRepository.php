<?php

namespace App\Repository;

use App\Entity\Qrcode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Qrcode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Qrcode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Qrcode[]    findAll()
 * @method Qrcode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QrcodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Qrcode::class);
    }

    public function getTokenToday(): ?string
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT token FROM qrcode WHERE qrcode.date = DATE(NOW());';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchOne();
        dump($result);
        return $result;
    }
    public function createToken()
    {
        $token = rand(1,9999999);
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'INSERT INTO qrcode VALUES (0,DATE(NOW()),'.$token.')';
        dump($sql);
        $query = $conn->executeQuery($sql);
//$result = $query->fetchOne();
        return $token;
    }
    

    // /**
    //  * @return Qrcode[] Returns an array of Qrcode objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('q')
    ->andWhere('q.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('q.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
    public function findOneBySomeField($value): ?Qrcode
    {
    return $this->createQueryBuilder('q')
    ->andWhere('q.exampleField = :val')
    ->setParameter('val', $value)
    ->getQuery()
    ->getOneOrNullResult()
    ;
    }
    */
}
