<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Organisateur;
use Doctrine\Common\Collections\Collection;
use App\Entity\Paiement;

#[ORM\Entity]
class Reservation
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id_reservation;

    #[ORM\Column(type: "integer")]
    private int $id_lieu;

    #[ORM\Column(type: "float")]
    private float $montant;

    #[ORM\Column(type: "string")]
    private string $heure_debut;

    #[ORM\Column(type: "string")]
    private string $heure_fin;

        #[ORM\ManyToOne(targetEntity: Organisateur::class, inversedBy: "reservations")]
    #[ORM\JoinColumn(name: 'id_organisateur', referencedColumnName: 'id_organisateur', onDelete: 'CASCADE')]
    private Organisateur $id_organisateur;

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $date_reservation;

    #[ORM\Column(type: "string", length: 8)]
    private string $num_reservation;

    public function getId_reservation()
    {
        return $this->id_reservation;
    }

    public function setId_reservation($value)
    {
        $this->id_reservation = $value;
    }

    public function getId_lieu()
    {
        return $this->id_lieu;
    }

    public function setId_lieu($value)
    {
        $this->id_lieu = $value;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setMontant($value)
    {
        $this->montant = $value;
    }

    public function getHeure_debut()
    {
        return $this->heure_debut;
    }

    public function setHeure_debut($value)
    {
        $this->heure_debut = $value;
    }

    public function getHeure_fin()
    {
        return $this->heure_fin;
    }

    public function setHeure_fin($value)
    {
        $this->heure_fin = $value;
    }

    public function getId_organisateur()
    {
        return $this->id_organisateur;
    }

    public function setId_organisateur($value)
    {
        $this->id_organisateur = $value;
    }

    public function getDate_reservation()
    {
        return $this->date_reservation;
    }

    public function setDate_reservation($value)
    {
        $this->date_reservation = $value;
    }

    public function getNum_reservation()
    {
        return $this->num_reservation;
    }

    public function setNum_reservation($value)
    {
        $this->num_reservation = $value;
    }

    #[ORM\OneToMany(mappedBy: "id_reservation", targetEntity: Paiement::class)]
    private Collection $paiements;
}
