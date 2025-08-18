<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Evenements;

#[ORM\Entity]
class Billets
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id_billet;

        #[ORM\ManyToOne(targetEntity: Evenements::class, inversedBy: "billetss")]
    #[ORM\JoinColumn(name: 'id_evenement', referencedColumnName: 'id_evenement', onDelete: 'CASCADE')]
    private Evenements $id_evenement;

    #[ORM\Column(type: "string", length: 255)]
    private string $titre;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    #[ORM\Column(type: "float")]
    private float $prix;

    #[ORM\Column(type: "integer")]
    private int $nbr_places;

    #[ORM\Column(type: "string")]
    private string $type;

    #[ORM\Column(type: "string", length: 255)]
    private string $qrCodePath;

    public function getId_billet()
    {
        return $this->id_billet;
    }

    public function setId_billet($value)
    {
        $this->id_billet = $value;
    }

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

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($value)
    {
        $this->prix = $value;
    }

    public function getNbr_places()
    {
        return $this->nbr_places;
    }

    public function setNbr_places($value)
    {
        $this->nbr_places = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($value)
    {
        $this->type = $value;
    }

    public function getQrCodePath()
    {
        return $this->qrCodePath;
    }

    public function setQrCodePath($value)
    {
        $this->qrCodePath = $value;
    }
}
