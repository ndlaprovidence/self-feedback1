<?php

namespace App\Repository;
use DateTime;
use DateInterval;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }
    public function getDateRepas(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate = date("Y-m-d");
        $madate2 = date("d")-7;
        $madate3 = date("Y-m")."-".$madate2;
        //dump($madate3." ".$madate);
        $sql = 'SELECT note_repas, note_valeur_environnement, note_date FROM student WHERE note_date <= "'.$madate.'" AND note_date >= "'.$madate3.'";';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        //dump($result);
        return $result;
    }
    public function getDateRepas1(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate = new DateTime(date("Y-m-d"));
        $sql = 'SELECT AVG(note_repas), AVG(note_valeur_environnement), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        return $result;
    }
    public function getDateRepas2(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate = new DateTime(date("Y-m-d"));
        $madate->sub(new DateInterval('P1D'));
        $sql = 'SELECT AVG(note_repas), AVG(note_valeur_environnement), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        return $result;
    }
    public function getDateRepas3(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate = new DateTime(date("Y-m-d"));
        $madate->sub(new DateInterval('P2D'));
        //dump($madate3." ".$madate);
        $sql = 'SELECT AVG(note_repas), AVG(note_valeur_environnement), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        //dump($result);
        return $result;
    }
    public function getDateRepas4(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate = new DateTime(date("Y-m-d"));
        $madate->sub(new DateInterval('P3D'));
        //dump($madate3." ".$madate);
        $sql = 'SELECT AVG(note_repas), AVG(note_valeur_environnement), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        //dump($result);
        return $result;
    }
    public function getDateRepas5(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate = new DateTime(date("Y-m-d"));
        $madate->sub(new DateInterval('P4D'));
        //dump($madate3." ".$madate);
        $sql = 'SELECT AVG(note_repas), AVG(note_valeur_environnement), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        //dump($result);
        return $result;
    }
    public function getDateEnv(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate = date("Y-m-d");
        $madate2 = date("d")-7;
        $madate3 = date("Y-m")."-".$madate2;
        //dump($madate3." ".$madate);
        $sql = 'SELECT note_valeur_environnement, note_date FROM student WHERE note_date <= "'.$madate.'" AND note_date >= "'.$madate3.'";';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        //dump($result);
        return $result;
    }
  
        // /**
    //  * @return NoteWeek[] Returns an array of Student objects
    //  */
    
    public function findWeek($startdate): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT note_date FROM student WHERE note_date BETWEEN '$startdate' AND date_add('$startdate', interval 4 day);";
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        return $result;
    }
    

    public function findNotesFromWeek(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate3 = new DateTime(date("Y-m-d"));
        $madate3->sub(new DateInterval('P4D'));
        $madate = new DateTime(date("Y-m-d"));
        $sql = 'SELECT note_repas as "Repas", note_valeur_environnement as "Environnement", note_date as "Date", note_Commentaire as "Commentaire", id FROM student WHERE note_date <= "'.$madate->format('Y-m-d').'" AND note_date >= "'.$madate3->format("Y-m-d").'";';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        return $result;
    }
}
