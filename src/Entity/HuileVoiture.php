<?php

namespace App\Entity;

use App\Repository\HuileVoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HuileVoitureRepository::class)]
class HuileVoiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $MarqueHuile = null;

    #[ORM\Column]
    private ?int $numHuile = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarqueHuile(): ?string
    {
        return $this->MarqueHuile;
    }

    public function setMarqueHuile(string $MarqueHuile): static
    {
        $this->MarqueHuile = $MarqueHuile;

        return $this;
    }

    public function getNumHuile(): ?int
    {
        return $this->numHuile;
    }

    public function setNumHuile(int $numHuile): static
    {
        $this->numHuile = $numHuile;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function __toString()
    {
        return $this->MarqueHuile;
    }
}
