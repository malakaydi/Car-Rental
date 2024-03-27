<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Image;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Matricule = null;

    #[ORM\Column]
    private ?int $nbre_place = null;

    #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\ManyToOne(targetEntity: Image::class)]
    #[ORM\JoinColumn(name: "image_id", referencedColumnName: "id", nullable: true)]
private ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    private ?Marque $marque = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    private ?Boite $boite = null;


    #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: Papier::class,cascade:["remove"])]
    private Collection $papiers;

    #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: Entretien::class, cascade:["remove"])]
    private Collection $entretiens;

    #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: Vidange::class, cascade:["remove"])]
    private Collection $vidanges;

    #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: Location::class)]
    private Collection $locations;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    public function __construct()
    {
        $this->papiers = new ArrayCollection();
        $this->entretiens = new ArrayCollection();
        $this->vidanges = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(string $Matricule): static
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    public function getNbrePlace(): ?int
    {
        return $this->nbre_place;
    }

    public function setNbrePlace(int $nbre_place): static
    {
        $this->nbre_place = $nbre_place;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

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

    public function getMarque(): ?marque
    {
        return $this->marque;
    }

    public function setMarque(?marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getBoite(): ?Boite
    {
        return $this->boite;
    }

    public function setBoite(?Boite $boite): static
    {
        $this->boite = $boite;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }
    
    public function setImage(?Image $image): static
    {
        $this->image = $image;
    
        return $this;
    }

    public function __toString()
    {
        return $this->Matricule;
    }

    /**
     * @return Collection<int, Papier>
     */
    public function getPapiers(): Collection
    {
        return $this->papiers;
    }

    public function addPapier(Papier $papier): static
    {
        if (!$this->papiers->contains($papier)) {
            $this->papiers->add($papier);
            $papier->setVoiture($this);
        }

        return $this;
    }

    public function removePapier(Papier $papier): static
    {
        if ($this->papiers->removeElement($papier)) {
            // set the owning side to null (unless already changed)
            if ($papier->getVoiture() === $this) {
                $papier->setVoiture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Entretien>
     */
    public function getEntretiens(): Collection
    {
        return $this->entretiens;
    }

    public function addEntretien(Entretien $entretien): static
    {
        if (!$this->entretiens->contains($entretien)) {
            $this->entretiens->add($entretien);
            $entretien->setVoiture($this);
        }

        return $this;
    }

    public function removeEntretien(Entretien $entretien): static
    {
        if ($this->entretiens->removeElement($entretien)) {
            // set the owning side to null (unless already changed)
            if ($entretien->getVoiture() === $this) {
                $entretien->setVoiture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vidange>
     */
    public function getVidanges(): Collection
    {
        return $this->vidanges;
    }

    public function addVidange(Vidange $vidange): static
    {
        if (!$this->vidanges->contains($vidange)) {
            $this->vidanges->add($vidange);
            $vidange->setVoiture($this);
        }

        return $this;
    }

    public function removeVidange(Vidange $vidange): static
    {
        if ($this->vidanges->removeElement($vidange)) {
            // set the owning side to null (unless already changed)
            if ($vidange->getVoiture() === $this) {
                $vidange->setVoiture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): static
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->setVoiture($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getVoiture() === $this) {
                $location->setVoiture(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }
}
