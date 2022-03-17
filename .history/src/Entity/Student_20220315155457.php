<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StudentRepository;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
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
    private $noteRepas;

    /**
     * @ORM\Column(type="smallint")
     */
    private $note_Valeur_Environnement;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $note_Commentaire;

    /**
     * @ORM\Column(type="date")
     */
    private $note_date;

    /**
     * @ORM\ManyToOne(targetEntity=Classes::class, inversedBy="students")
     */
    private $classe;

    /**
     * @ORM\Column(type="smallint")
     */
    private $noteChaleur;

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

    public function getNoteRepas(): ?int
    {
        return $this->noteRepas;
    }

    public function setNoteRepas(int $noteRepas): self
    {
        $this->noteRepas = $noteRepas;

        return $this;
    }

    public function getNoteValeurEnvironnement(): ?int
    {
        return $this->note_Valeur_Environnement;
    }

    public function setNoteValeurEnvironnement(int $note_Valeur_Environnement): self
    {
        $this->note_Valeur_Environnement = $note_Valeur_Environnement;

        return $this;
    }

    public function getNoteCommentaire(): ?string
    {
        return $this->note_Commentaire;
    }

    public function setNoteCommentaire(?string $note_Commentaire): self
    {
        $this->note_Commentaire = $note_Commentaire;

        return $this;
    }

    public function getNoteDate(): ?\DateTimeInterface
    {
        return $this->note_date;
    }

    public function setNoteDate(\DateTimeInterface $note_date): self
    {
        //$note_date=date("d/m/Y");
        $this->note_date = $note_date;

        return $this;
    }

    public function getClasse(): ?classes
    {
        return $this->classe;
    }

    public function setClasse(?classes $classe): self
    {
        $this->classe = $classe;

        return $this;
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

    public function getNoteGout(): ?int
    {
        return $this->noteGout;
    }

    public function setNoteGout(int $noteGout): self
    {
        $this->noteGout = $noteGout;

        return $this;
    }

    public function getNoteQuantite(): ?int
    {
        return $this->notequantite;
    }

    public function setNoteQuantite(int $quantite): self
    {
        $this->notequantite = $quantite;

        return $this;
    }

    public function getNoteAcceuil(): ?int
    {
        return $this->noteacceuil;
    }

    public function setNoteAcceuil(int $acceuil): self
    {
        $this->noteacceuil = $acceuil;

        return $this;
    }

    public function getNoteDiversite(): ?int
    {
        return $this->notediversite;
    }

    public function setNoteDiversite(int $diversite): self
    {
        $this->notediversite = $diversite;

        return $this;
    }

    public function getNoteHygiene(): ?int
    {
        return $this->notehygiene;
    }

    public function setNoteHygiene(int $hygiene): self
    {
        $this->notehygiene = $hygiene;

        return $this;
    }
}