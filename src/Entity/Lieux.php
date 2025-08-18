<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Lieux
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id_lieu;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "text")]
    private string $adresse;

    #[ORM\Column(type: "integer")]
    private int $capacite_max;

    public function getId_lieu()
    {
        return $this->id_lieu;
    }

    public function setId_lieu($value)
    {
        $this->id_lieu = $value;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($value)
    {
        $this->nom = $value;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($value)
    {
        $this->adresse = $value;
    }

    public function getCapacite_max()
    {
        return $this->capacite_max;
    }

    public function setCapacite_max($value)
    {
        $this->capacite_max = $value;
    }
}
