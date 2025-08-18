<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
class Evaluation
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id_evaluation;

    #[ORM\Column(type: "integer")]
    private int $id_participant;

    #[ORM\Column(type: "integer")]
    private int $id_evenement;

    #[ORM\Column(type: "float")]
    private float $note_contenu;

    #[ORM\Column(type: "float")]
    private float $note_interaction;

    #[ORM\Column(type: "float")]
    private float $note_moyenne;

    #[ORM\Column(type: "float")]
    private float $note_soumission;

    public function getId_evaluation()
    {
        return $this->id_evaluation;
    }

    public function setId_evaluation($value)
    {
        $this->id_evaluation = $value;
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

    public function getNote_contenu()
    {
        return $this->note_contenu;
    }

    public function setNote_contenu($value)
    {
        $this->note_contenu = $value;
    }

    public function getNote_interaction()
    {
        return $this->note_interaction;
    }

    public function setNote_interaction($value)
    {
        $this->note_interaction = $value;
    }

    public function getNote_moyenne()
    {
        return $this->note_moyenne;
    }

    public function setNote_moyenne($value)
    {
        $this->note_moyenne = $value;
    }

    public function getNote_soumission()
    {
        return $this->note_soumission;
    }

    public function setNote_soumission($value)
    {
        $this->note_soumission = $value;
    }
}
