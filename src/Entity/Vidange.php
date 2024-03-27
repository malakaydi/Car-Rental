<?php

namespace App\Entity;

use App\Repository\VidangeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VidangeRepository::class)]
class Vidange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $filtreAir = null;

    #[ORM\Column(length: 255)]
    private ?string $filtreHuile = null;

    #[ORM\Column(length: 255)]
    private ?string $filtreGasoil = null;

    #[ORM\ManyToOne(inversedBy: 'vidanges')]
    private ?HuileVoiture $huilVoiture = null;

    #[ORM\ManyToOne(inversedBy: 'vidanges')]
    private ?Voiture $voiture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFiltreAir(): ?string
    {
        return $this->filtreAir;
    }

    public function setFiltreAir(string $filtreAir): static
    {
        $this->filtreAir = $filtreAir;

        return $this;
    }

    public function getFiltreHuile(): ?string
    {
        return $this->filtreHuile;
    }

    public function setFiltreHuile(string $filtreHuile): static
    {
        $this->filtreHuile = $filtreHuile;

        return $this;
    }

    public function getFiltreGasoil(): ?string
    {
        return $this->filtreGasoil;
    }

    public function setFiltreGasoil(string $filtreGasoil): static
    {
        $this->filtreGasoil = $filtreGasoil;

        return $this;
    }

    public function getHuilVoiture(): ?HuileVoiture
    {
        return $this->huilVoiture;
    }

    public function setHuilVoiture(?HuileVoiture $huilVoiture): static
    {
        $this->huilVoiture = $huilVoiture;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): static
    {
        $this->voiture = $voiture;

        return $this;
    }
}
