<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\User;

#[ORM\Entity]
class Partenaire
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id_partenaire',type: "integer")]
    private int $id_partenaire;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "organisateurs")]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\Valid]
    private User $user; // Reference to the User entity

    #[ORM\Column(name: 'type_service', type: "string", length: 20)]
    #[Assert\NotBlank(message: "Champ obligatoire")]
    #[Assert\Length(max: 20, maxMessage: "Maximum 20 caractères autorisés")]
    private string $type_service;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank(message: "Champ obligatoire")]
    #[Assert\Length(max: 100, maxMessage: "Maximum 100 caractères autorisés")]
    private string $site_web;

    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: "Champ obligatoire")]
    #[Assert\PositiveOrZero(message: "Le nombre de contacts doit être un entier positif")]
    private int $nbre_contacts;

    public function getId_partenaire()
    {
        return $this->id_partenaire;
    }
    public function getIdpartenaire()
    {
        return $this->id_partenaire;
    }

    public function setId_partenaire($value)
    {
        $this->id_partenaire = $value;
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

    public function getTypeservice()
    {
        return $this->type_service;
    }
    public function gettype_service()
    {
        return $this->type_service;
    }

    public function setTypeservice($value)
    {
        $this->type_service = $value;
    }

    public function getsiteweb()
    {
        return $this->site_web;
    }
    public function getsite_web()
    {
        return $this->site_web;
    }

    public function setsiteweb($value)
    {
        $this->site_web = $value;
    }

    public function getnbrecontacts()
    {
        return $this->nbre_contacts;
    }
    public function getnbre_contacts()
    {
        return $this->nbre_contacts;
    }

    public function setnbrecontacts($value)
    {
        $this->nbre_contacts = $value;
    }
}
