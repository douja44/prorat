<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Reservation;

#[ORM\Entity]
class Paiement
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id_paiement;

        #[ORM\ManyToOne(targetEntity: Reservation::class, inversedBy: "paiements")]
    #[ORM\JoinColumn(name: 'id_reservation', referencedColumnName: 'id_reservation', onDelete: 'CASCADE')]
    private Reservation $id_reservation;

    #[ORM\Column(type: "float")]
    private float $montant;

    #[ORM\Column(type: "string")]
    private string $mode_paiement;

    #[ORM\Column(type: "string")]
    private string $statut;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $date_paiement;

    public function getId_paiement()
    {
        return $this->id_paiement;
    }

    public function setId_paiement($value)
    {
        $this->id_paiement = $value;
    }

    public function getId_reservation()
    {
        return $this->id_reservation;
    }

    public function setId_reservation($value)
    {
        $this->id_reservation = $value;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setMontant($value)
    {
        $this->montant = $value;
    }

    public function getMode_paiement()
    {
        return $this->mode_paiement;
    }

    public function setMode_paiement($value)
    {
        $this->mode_paiement = $value;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($value)
    {
        $this->statut = $value;
    }

    public function getDate_paiement()
    {
        return $this->date_paiement;
    }

    public function setDate_paiement($value)
    {
        $this->date_paiement = $value;
    }
}
