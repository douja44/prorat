<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use App\Entity\Organisateur;

#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 20)]
    #[Assert\NotBlank(message: "Nom is required.")]
    #[Assert\Length(min: 3, max: 20, minMessage: "Nom should be at least {{ limit }} characters long.")]
    private string $nom;

    #[ORM\Column(type: "string", length: 20)]
    #[Assert\NotBlank(message: "Prenom is required.")]
    #[Assert\Length(min: 3, max: 20, minMessage: "Prenom should be at least {{ limit }} characters long.")]
    private string $prenom;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(message: "Email is required.")]
    #[Assert\Email(message: "Please provide a valid email address.")]
    private string $email;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank(message: "Mot de passe is required.")]
    #[Assert\Length(min: 8, max: 100, minMessage: "Mot de passe should be at least {{ limit }} characters long.")]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/",
        message: "Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial."
    )]
    private string $mot_de_passe;

    #[ORM\Column(type: "date",nullable:true)]
    #[Assert\NotBlank(message:"La date de naissance est obligatoire.")]
    #[Assert\LessThan("today", message: "Date de naissance ne peut pas être dans le futur.")]
    private  ?\DateTimeInterface $date_naiss = null;
    
    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(message: "Adresse is required.")]
    private string $adresse;

    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: "Telephone is required.")]
    #[Assert\Regex(
    pattern: "/^\d{8}$/",
    message: "Telephone must contain exactly 8 digits."
    )]
    private int $telephone;

    #[ORM\Column(type: "json")]
    private array $roles = [];

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $date_inscription;

    #[ORM\Column(type: "string", length: 10, nullable: true)]
    private ?string $verification_code = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $verification_expiry = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $profile_image = null;

    #[ORM\Column(type: "integer")]
    private int $failed_attempts;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $blocked_until = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $lockout_end_time = null;

    // Getter and Setter methods

    // Add assert validation functions to the properties
    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($value)
    {
        $this->nom = $value;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($value)
    {
        $this->prenom = $value;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function getMotdepasse()
    {
        return $this->mot_de_passe;
    }

    public function setMotdepasse($value)
    {
        $this->mot_de_passe = $value;
    }

    public function getDatenaiss()
    {
        return $this->date_naiss;
    }

    public function setDatenaiss($value)
    {
        $this->date_naiss = $value;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($value)
    {
        $this->adresse = $value;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($value)
    {
        $this->telephone = $value;
    }

    public function getDateinscription()
    {
        return $this->date_inscription;
    }

    public function setDateinscription($value)
    {
        $this->date_inscription = $value;
    }

    public function getVerificationcode()
    {
        return $this->verification_code;
    }

    public function setVerificationcode($value)
    {
        $this->verification_code = $value;
    }

    public function getVerificationexpiry()
    {
        return $this->verification_expiry;
    }

    public function setVerificationexpiry($value)
    {
        $this->verification_expiry = $value;
    }

    public function getProfileimage()
    {
        return $this->profile_image;
    }

    public function setProfileimage($value)
    {
        $this->profile_image = $value;
    }

    public function getFailedattempts()
    {
        return $this->failed_attempts;
    }

    public function setFailedattempts($value)
    {
        $this->failed_attempts = $value;
    }

    public function getBlockeduntil()
    {
        return $this->blocked_until;
    }

    public function setBlockeduntil($value)
    {
        $this->blocked_until = $value;
    }

    public function getLockoutendtime()
    {
        return $this->lockout_end_time;
    }

    public function setLockoutendtime($value)
    {
        $this->lockout_end_time = $value;
    }

    // UserInterface methods
    public function getPassword(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setPassword(string $password): self
    {
        $this->mot_de_passe = $password;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER'; // Ensure every user has at least ROLE_USER
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials()
    {
        // Clear sensitive data if needed
    }

    // Relationships (OneToMany)
    #[ORM\OneToMany(mappedBy: "user", targetEntity: Organisateur::class, cascade: ["persist", "remove"])]
    private Collection $organisateurs;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Admin::class, cascade: ["persist", "remove"])]
    private Collection $admins;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Participants::class, cascade: ["persist", "remove"])]
    private Collection $participants;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Partenaire::class, cascade: ["persist", "remove"])]
    private Collection $partenaires;

    public function __construct()
    {
        $this->organisateurs = new ArrayCollection();
        $this->admins = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->partenaires = new ArrayCollection();
    }

    public function getOrganisateurs(): Collection
    {
        return $this->organisateurs;
    }

    public function addOrganisateur(Organisateur $organisateur): self
    {
        if (!$this->organisateurs->contains($organisateur)) {
            $this->organisateurs[] = $organisateur;
            $organisateur->setUser($this);
        }
        return $this;
    }

    public function removeOrganisateur(Organisateur $organisateur): self
    {
        if ($this->organisateurs->removeElement($organisateur)) {
            if ($organisateur->getUser() === $this) {
                $organisateur->setUser(null);
            }
        }
        return $this;
    }

    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(Admin $admin): self
    {
        if (!$this->admins->contains($admin)) {
            $this->admins[] = $admin;
            $admin->setUser($this);
        }
        return $this;
    }

    public function removeAdmin(Admin $admin): self
    {
        if ($this->admins->removeElement($admin)) {
            if ($admin->getUser() === $this) {
                $admin->setUser(null);
            }
        }
        return $this;
    }

    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participants $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setUser($this);
        }
        return $this;
    }

    public function removeParticipant(Participants $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            if ($participant->getUser() === $this) {
                $participant->setUser(null);
            }
        }
        return $this;
    }

    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaires->contains($partenaire)) {
            $this->partenaires[] = $partenaire;
            $partenaire->setUser($this);
        }
        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaires->removeElement($partenaire)) {
            if ($partenaire->getUser() === $this) {
                $partenaire->setUser(null);
            }
        }
        return $this;
    }
}
