<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $idoffre = null;

    #[ORM\Column(type: "string", length: 100)]
    private string $titre;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(name: "date_debut", type: "string", length: 255)]
    private string $dateDebut;

    #[ORM\Column(type: "float")]
    private float $tauxReduction;

    public function getIdoffre(): ?int
    {
        return $this->idoffre;
    }

    public function setIdoffre(int $value): self
    {
        $this->idoffre = $value;
        return $this;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setTitre(string $value): self
    {
        $this->titre = $value;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $value): self
    {
        $this->description = $value;
        return $this;
    }

    public function getDateDebut(): string
    {
        return $this->dateDebut;
    }

    public function setDateDebut(string $value): self
    {
        $this->dateDebut = $value;
        return $this;
    }

    public function getTauxReduction(): float
    {
        return $this->tauxReduction;
    }

    public function setTauxReduction(float $value): self
    {
        $this->tauxReduction = $value;
        return $this;
    }
}