<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Evenements;
use App\Entity\Offre;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'id_user', type: 'integer')]
    private int $idUser;

    #[ORM\Column(name: 'id_event', type: 'integer')]
    private int $idEvent;

    #[ORM\Column(name: 'idoffre', type: 'integer')]
    private int $idoffre;

    #[ORM\Column(type: 'string', length: 255)]
    private string $date_expiration;

    #[ORM\Column(type: 'float')]
    private float $montant;

    #[ORM\Column(type: 'text')]
    private string $conditions_contrat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getidUser(): int
    {
        return $this->idUser;
    }

    public function setidUser(int $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getIdEvent(): int
    {
        return $this->idEvent;
    }

    public function setIdEvent(int $idevent): self
    {
        $this->idEvent = $idevent;
        return $this;
    }

    public function getIdoffre(): int
    {
        return $this->idoffre;
    }

    public function setIdoffre(int $idoffre): self
    {
        $this->idoffre = $idoffre;
        return $this;
    }

    public function getDateExpiration(): string
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(string $date_expiration): self
    {
        $this->date_expiration = $date_expiration;
        return $this;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    public function getConditionsContrat(): string
    {
        return $this->conditions_contrat;
    }

    public function setConditionsContrat(string $conditions_contrat): self
    {
        $this->conditions_contrat = $conditions_contrat;
        return $this;
    }
}  