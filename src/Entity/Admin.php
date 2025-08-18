<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\User;

#[ORM\Entity]
class Admin
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id_admin;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "organisateurs")]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id", onDelete: "CASCADE")]
    private User $user; // Reference to the User entity

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $created_at;

    public function getId_admin()
    {
        return $this->id_admin;
    }

    public function setId_admin($value)
    {
        $this->id_admin = $value;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($value)
    {
        $this->created_at = $value;
    }
}
