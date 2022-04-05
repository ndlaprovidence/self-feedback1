<?php

namespace App\Entity;

use App\Repository\ChartChoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;
/**
 * @ORM\Entity(repositoryClass=ChartChoiceRepository::class)
 */
class ChartChoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public function __toString():string
    {
        if (!isset($this->type)) {
            $this->type = "bar";
        }
        
        return $this->type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
