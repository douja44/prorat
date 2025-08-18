<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Retours
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id_retours;

    #[ORM\Column(type: "integer")]
    private int $id_participant;

    #[ORM\Column(type: "integer")]
    private int $id_evenement;

    #[ORM\Column(type: "string")]
    private string $type_retours;

    #[ORM\Column(type: "string", length: 100)]
    private string $contenu_retours;

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $date_soumission_retours;

    public function getId_retours()
    {
        return $this->id_retours;
    }

    public function setId_retours($value)
    {
        $this->id_retours = $value;
    }

    public function getId_participant()
    {
        return $this->id_participant;
    }

    public function setId_participant($value)
    {
        $this->id_participant = $value;
    }

    public function getId_evenement()
    {
        return $this->id_evenement;
    }

    public function setId_evenement($value)
    {
        $this->id_evenement = $value;
    }

    public function getType_retours()
    {
        return $this->type_retours;
    }

    public function setType_retours($value)
    {
        $this->type_retours = $value;
    }

    public function getContenu_retours()
    {
        return $this->contenu_retours;
    }

    public function setContenu_retours($value)
    {
        $this->contenu_retours = $value;
    }

    public function getDate_soumission_retours()
    {
        return $this->date_soumission_retours;
    }

    public function setDate_soumission_retours($value)
    {
        $this->date_soumission_retours = $value;
    }
}
