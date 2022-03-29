<?php

namespace App\Entity;

use App\Repository\StudentCritereRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentCritereRepository::class)
 */
class StudentCritere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $noteChaleur;

    /**
     * @ORM\ManyToOne(targetEntity=student::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idStudent;

    /**
     * @ORM\ManyToOne(targetEntity=critere::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCritere;

    /**
     * @ORM\Column(type="smallint")
     */
    private $noteGout;

    /**
     * @ORM\Column(type="smallint")
     */
    private $notequantite;

    /**
     * @ORM\Column(type="smallint")
     */
    private $noteacceuil;

    /**
     * @ORM\Column(type="smallint")
     */
    private $notediversite;

    /**
     * @ORM\Column(type="smallint")
     */
    private $notehygiene;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoteChaleur(): ?int
    {
        return $this->noteChaleur;
    }

    public function setNoteChaleur(int $noteChaleur): self
    {
        $this->noteChaleur = $noteChaleur;

        return $this;
    }

    public function getIdStudent(): ?student
    {
        return $this->idStudent;
    }

    public function setIdStudent(?student $idStudent): self
    {
        $this->idStudent = $idStudent;

        return $this;
    }

    public function getIdCritere(): ?critere
    {
        return $this->idCritere;
    }

    public function setIdCritere(?critere $idCritere): self
    {
        $this->idCritere = $idCritere;

        return $this;
    }

    public function getNoteGout(): ?int
    {
        return $this->noteGout;
    }

    public function setNoteGout(int $noteGout): self
    {
        $this->noteGout = $noteGout;

        return $this;
    }

    public function getNotequantite(): ?int
    {
        return $this->notequantite;
    }

    public function setNotequantite(int $notequantite): self
    {
        $this->notequantite = $notequantite;

        return $this;
    }

    public function getNoteacceuil(): ?int
    {
        return $this->noteacceuil;
    }

    public function setNoteacceuil(int $noteacceuil): self
    {
        $this->noteacceuil = $noteacceuil;

        return $this;
    }

    public function getNotediversite(): ?int
    {
        return $this->notediversite;
    }

    public function setNotediversite(int $notediversite): self
    {
        $this->notediversite = $notediversite;

        return $this;
    }

    public function getNotehygiene(): ?int
    {
        return $this->notehygiene;
    }

    public function setNotehygiene(int $notehygiene): self
    {
        $this->notehygiene = $notehygiene;

        return $this;
    }
}
