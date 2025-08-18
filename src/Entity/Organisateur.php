<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\User;
use App\Entity\Reservation;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Organisateur
{
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "organisateur")]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\Valid]
    private User $user;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_organisateur', type: "integer")]
    private int $id_organisateur;

    #[ORM\Column(type: "string", length: 20)]
    #[Assert\NotBlank(message: "Le champ de travail ne peut pas être vide.")]
    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: "Le champ de travail doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le champ de travail ne peut pas dépasser {{ limit }} caractères."
    )]
    private string $workField;

    #[ORM\Column(type: "string", length: 20)]
    #[Assert\NotBlank(message: "L'email professionnel ne peut pas être vide.")]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas un email valide.")]
    private string $workEmail;

    #[ORM\OneToMany(mappedBy: "id_organisateur", targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    // ... Getters & Setters below

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getIdorganisateur()
    {
        return $this->id_organisateur;
    }

    public function setIdorganisateur($value)
    {
        $this->id_organisateur = $value;
    }

    public function getWorkField()
    {
        return $this->workField;
    }

    public function setWorkField($value)
    {
        $this->workField = $value;
    }

    public function getWorkEmail()
    {
        return $this->workEmail;
    }

    public function setWorkEmail($value)
    {
        $this->workEmail = $value;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setId_organisateur($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            if ($reservation->getId_organisateur() === $this) {
                $reservation->setId_organisateur(null);
            }
        }

        return $this;
    }
}
