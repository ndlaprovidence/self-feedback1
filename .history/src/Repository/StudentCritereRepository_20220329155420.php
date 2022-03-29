<?php

namespace App\Repository;

use App\Entity\StudentCritere;
use App\Repository\CritereRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

 
    public function setCritereRep(CritereRepository $critereRepository)
    {
        $this->critereRepository=$critereRepository;
    }
 
    public function getLesCriteresSQL()
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate = new DateTime(date("Y-m-d"));
        $strSQL = "" ;
        $this->critereRepository->findAll();
        dump($this->critereRepository->findAll());
        //'SELECT AVG(note_repas), AVG(note_valeur_environnement), AVG(note_chaleur), AVG(note_gout), AVG(notequantite), AVG(noteacceuil), AVG(notediversite), AVG(notehygiene), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";'
    }

    public function getDateRepas1(): ?array
    {
        
        $sql = $this->getLesCriteresSQL($CritereRepository);
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        return $result;
    }
    public function getDateRepas2(): ?array
    {
        $conn = $this->getEntityManager()->getConnection();
        $madate = new DateTime(date("Y-m-d"));
        $madate->sub(new DateInterval('P1D'));
        $sql = 'SELECT AVG(note_repas), AVG(note_valeur_environnement), AVG(note_chaleur), AVG(note_gout), AVG(notequantite), AVG(noteacceuil), AVG(notediversite), AVG(notehygiene), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";';
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
        $sql = 'SELECT AVG(note_repas), AVG(note_valeur_environnement), AVG(note_chaleur), AVG(note_gout), AVG(notequantite), AVG(noteacceuil), AVG(notediversite), AVG(notehygiene), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";';
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
        $sql = 'SELECT AVG(note_repas), AVG(note_valeur_environnement), AVG(note_chaleur), AVG(note_gout), AVG(notequantite), AVG(noteacceuil), AVG(notediversite), AVG(notehygiene), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";';
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
        $sql = 'SELECT AVG(note_repas), AVG(note_valeur_environnement), AVG(note_chaleur), AVG(note_gout), AVG(notequantite), AVG(noteacceuil), AVG(notediversite), AVG(notehygiene), note_date FROM student WHERE note_date = "'.$madate->format("Y-m-d").'";';
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
        $sql = 'SELECT note_repas as "Repas",note_chaleur as "Chaleur", note_gout as "Gout", note_valeur_environnement as "Environnement", note_date as "Date", note_Commentaire as "Commentaire", id FROM student WHERE note_date <= "'.$madate->format('Y-m-d').'" AND note_date >= "'.$madate3->format("Y-m-d").'";';
        $query = $conn->executeQuery($sql);
        $result = $query->fetchAll();
        return $result;
    }
}
