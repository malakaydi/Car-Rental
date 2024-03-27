<?php

namespace App\Entity;

use App\Repository\EntretienRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntretienRepository::class)]
class Entretien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $DateEntretien = null;

    #[ORM\Column(length: 255)]
    private ?string $DescriptionEntretien = null;

    #[ORM\ManyToOne(inversedBy: 'entretiens')]
    private ?Voiture $voiture = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateEntretien(): ?\DateTimeImmutable
    {
        return $this->DateEntretien;
    }

    public function setDateEntretien(\DateTimeImmutable $DateEntretien): static
    {
        $this->DateEntretien = $DateEntretien;

        return $this;
    }

    public function getDescriptionEntretien(): ?string
    {
        return $this->DescriptionEntretien;
    }

    public function setDescriptionEntretien(string $DescriptionEntretien): static
    {
        $this->DescriptionEntretien = $DescriptionEntretien;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
}
