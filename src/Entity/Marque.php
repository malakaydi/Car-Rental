<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libellemarque = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLibelleMarque(): ?string
    {
        return $this->libellemarque;
    }

    public function setLibelleMarque(string $libellemarque): static
    {
        $this->libellemarque = $libellemarque;

        return $this;
    }
    public function __toString()
{
    return $this->libellemarque;
}
}
