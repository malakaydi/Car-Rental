<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
class PropertySearch
{
    private $nom;
    /**
     * @var string|null
     * @Assert\Choice(choices={"luxury", "intermediate", "economic"}, message="Invalid category.")
     */
    private $category;

    public function getNom(): ?string{
return $this->nom;
    }

    public function setNom(string $nom): self{
         $this->nom=$nom;
         return $this;
            }

            public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }
}