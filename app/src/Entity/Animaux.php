<?php

namespace App\Entity;

use App\Repository\AnimauxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimauxRepository::class)]
class Animaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_animal = null;

    #[ORM\Column(length: 50)]
    private ?string $espece = null;

    #[ORM\Column(type:'text')]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $image_animal = null;

    #[ORM\Column]
    private ?int $poids = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\ManyToOne(inversedBy: 'animauxes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habitat $habitat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAnimal(): ?string
    {
        return $this->nom_animal;
    }

    public function setNomAnimal(string $nom_animal): static
    {
        $this->nom_animal = $nom_animal;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): static
    {
        $this->espece = $espece;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageAnimal(): ?string
    {
        return $this->image_animal;
    }

    public function setImageAnimal(string $image_animal): static
    {
        $this->image_animal = $image_animal;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getHabitat(): ?Habitat
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitat $habitat): static
    {
        $this->habitat = $habitat;

        return $this;
    }

    
}
