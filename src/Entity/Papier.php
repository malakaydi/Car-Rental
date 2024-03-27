<?php

namespace App\Entity;

use App\Repository\PapierRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PapierRepository::class)]
class Papier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $DateValidation = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $ExpiresAt = null;

    #[ORM\ManyToOne(inversedBy: 'papiers')]
    private ?Voiture $voiture = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    /**
 * @ORM\Column(length: 255)
 */
private ?string $TypePapier = null;

    
 
public function getTypePapier(): ?string
{
    return $this->TypePapier;
}

public function setTypePapier(?string $TypePapier): self
{
    $this->TypePapier = $TypePapier;

    return $this;
}

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateValidation(): ?\DateTimeImmutable
    {
        return $this->DateValidation;
    }

    public function setDateValidation(\DateTimeImmutable $DateValidation): static
    {
        $this->DateValidation = $DateValidation;

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

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->ExpiresAt;
    }

    public function setExpiresAt(\DateTimeImmutable $ExpiresAt): static
    {
        $this->ExpiresAt = $ExpiresAt;

        return $this;
    }



}
