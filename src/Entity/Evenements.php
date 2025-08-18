<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use App\Entity\Billets;

#[ORM\Entity]
class Evenements
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id_evenement;

    #[ORM\Column(type: "string", length: 255)]
    private string $titre;

    #[ORM\Column(type: "text")]
    private string $description;

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $date;

    #[ORM\Column(type: "string")]
    private string $heure;

    #[ORM\Column(type: "integer")]
    private int $capacite;

    #[ORM\Column(type: "string", length: 255)]
    private string $stat;

    #[ORM\Column(type: "string")]
    private string $typee;

    #[ORM\Column(type: "string", length: 255)]
    private string $imageUrl;

    #[ORM\Column(type: "integer")]
    private int $idLieu;

    public function getId_evenement()
    {
        return $this->id_evenement;
    }

    public function setId_evenement($value)
    {
        $this->id_evenement = $value;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($value)
    {
        $this->titre = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($value)
    {
        $this->date = $value;
    }

    public function getHeure()
    {
        return $this->heure;
    }

    public function setHeure($value)
    {
        $this->heure = $value;
    }

    public function getCapacite()
    {
        return $this->capacite;
    }

    public function setCapacite($value)
    {
        $this->capacite = $value;
    }

    public function getStat()
    {
        return $this->stat;
    }

    public function setStat($value)
    {
        $this->stat = $value;
    }

    public function getTypee()
    {
        return $this->typee;
    }

    public function setTypee($value)
    {
        $this->typee = $value;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function setImageUrl($value)
    {
        $this->imageUrl = $value;
    }

    public function getIdLieu()
    {
        return $this->idLieu;
    }

    public function setIdLieu($value)
    {
        $this->idLieu = $value;
    }

    #[ORM\OneToMany(mappedBy: "id_evenement", targetEntity: Billets::class)]
    private Collection $billetss;

        public function getBilletss(): Collection
        {
            return $this->billetss;
        }
    
        public function addBillets(Billets $billets): self
        {
            if (!$this->billetss->contains($billets)) {
                $this->billetss[] = $billets;
                $billets->setId_evenement($this);
            }
    
            return $this;
        }
    
        public function removeBillets(Billets $billets): self
        {
            if ($this->billetss->removeElement($billets)) {
                // set the owning side to null (unless already changed)
                if ($billets->getId_evenement() === $this) {
                    $billets->setId_evenement(null);
                }
            }
    
            return $this;
        }
}
