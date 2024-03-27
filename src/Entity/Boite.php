<?php

namespace App\Entity;

use App\Repository\BoiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoiteRepository::class)]
class Boite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $typeBoite = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTypeBoite(): ?string
    {
        return $this->typeBoite;
    }

    public function setTypeBoite(string $typeBoite): static
    {
        $this->typeBoite = $typeBoite;

        return $this;
    }

    public function __toString()
    {
        return $this->typeBoite;
    }
}
