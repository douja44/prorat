<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $idoffre = null;

    // Titre : obligatoire, max 100 caractères
    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    #[Assert\Length(max: 100, maxMessage: 'Le titre ne doit pas dépasser {{ limit }} caractères.')]
    private ?string $titre = null;

    // Description : obligatoire, max 400 caractères (on garde TEXT en BDD, contrôle côté serveur)
    #[ORM\Column(type: "text")]
    #[Assert\NotBlank(message: 'La description est obligatoire.')]
    #[Assert\Length(max: 400, maxMessage: 'La description ne doit pas dépasser {{ limit }} caractères.')]
    private ?string $description = null;

    // date_debut reste VARCHAR en BDD -> on valide format + > aujourd’hui
    #[ORM\Column(name: "date_debut", type: "string", length: 255)]
    #[Assert\NotBlank(message: 'La date de début est obligatoire.')]
    #[Assert\Regex(pattern: '/^\d{2}\/\d{2}\/\d{4}$/', message: 'Format invalide. Attendu : jj/mm/aaaa.')]
    private ?string $dateDebut = null;

    // Taux de réduction : entre 5 et 45 inclus
    #[ORM\Column(type: "float")]
    #[Assert\NotNull(message: 'Le taux de réduction est obligatoire.')]
    #[Assert\Range(min: 5, max: 45, notInRangeMessage: 'Le taux de réduction doit être entre {{ min }}% et {{ max }}%.')]
    private ?float $tauxReduction = null;

    // ====== Callback de validation : dateDebut > aujourd’hui (sécurisé) ======
    #[Assert\Callback]
    public function validateDateDebut(ExecutionContextInterface $context): void
    {
        if ($this->dateDebut === null || $this->dateDebut === '') {
            // NotBlank prendra le relais
            return;
        }

        $dt = \DateTime::createFromFormat('d/m/Y', (string) $this->dateDebut);
        $errors = \DateTime::getLastErrors();
        $warningCount = \is_array($errors) ? (int)($errors['warning_count'] ?? 0) : 0;
        $errorCount   = \is_array($errors) ? (int)($errors['error_count'] ?? 0) : 0;

        if (!$dt || $warningCount > 0 || $errorCount > 0) {
            $context->buildViolation('Date invalide (jj/mm/aaaa).')
                ->atPath('dateDebut')->addViolation();
            return;
        }

        $today = new \DateTime('today');
        if ($dt <= $today) {
            $context->buildViolation('La date de début doit être postérieure à aujourd’hui.')
                ->atPath('dateDebut')->addViolation();
        }
    }

    // ====== Getters / Setters ======

    public function getIdoffre(): ?int { return $this->idoffre; }
    public function setIdoffre(int $value): self { $this->idoffre = $value; return $this; }

    public function getTitre(): ?string { return $this->titre; }
    public function setTitre(string $value): self { $this->titre = $value; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $value): self { $this->description = $value; return $this; }

    public function getDateDebut(): ?string { return $this->dateDebut; }
    public function setDateDebut(string $value): self { $this->dateDebut = $value; return $this; }

    public function getTauxReduction(): ?float { return $this->tauxReduction; }
    public function setTauxReduction(float $value): self { $this->tauxReduction = $value; return $this; }
}
