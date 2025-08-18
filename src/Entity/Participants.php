<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\User;

#[ORM\Entity]
class Participants
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id_participant',type: "integer")]
    private int $id_participant;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "organisateurs")]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\Valid]
    private User $user; 

    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: "Champ obligatoire")]
    #[Assert\PositiveOrZero(message: "Le nombre de participations doit être un entier positif")]
    private int $nombreParticipations;

    public function getIdparticipant()
    {
        return $this->id_participant;
    }
    public function getId_participant()
    {
        return $this->id_participant;
    }

    public function setIdparticipant($value)
    {
        $this->id_participant = $value;
    }

    // Getter and setter for user
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getNombreParticipations()
    {
        return $this->nombreParticipations;
    }

    public function setNombreParticipations($value)
    {
        $this->nombreParticipations = $value;
    }
}
