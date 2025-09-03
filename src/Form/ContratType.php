<?php

namespace App\Form;

use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idUser', IntegerType::class, [
                'label' => 'ID Utilisateur',
                'constraints' => [
                    new Assert\NotBlank(message: "L'ID utilisateur est obligatoire."),
                    new Assert\Type(type: 'integer', message: "L'ID utilisateur doit être un entier."),
                ],
            ])
            ->add('idoffre', IntegerType::class, [
                'label' => 'ID Offre',
                'disabled' => true,
            ])
            ->add('idEvent', IntegerType::class, [
                'label' => 'ID Événement',
                'constraints' => [
                    new Assert\NotBlank(message: "L'ID événement est obligatoire."),
                    new Assert\Type(type: 'integer', message: "L'ID événement doit être un entier."),
                ],
            ])
            ->add('dateExpiration', TextType::class, [
                'label' => 'Date d\'expiration (jj/mm/aaaa)',
                'attr' => ['placeholder' => 'jj/mm/aaaa'],
                'constraints' => [
                    new Assert\NotBlank(message: 'La date d\'expiration est obligatoire.'),
                    new Assert\Regex(
                        pattern: '/^\d{2}\/\d{2}\/\d{4}$/',
                        message: 'Format attendu : jj/mm/aaaa.'
                    ),
                ],
            ])
            ->add('montant', NumberType::class, [
                'label' => 'Montant',
                'constraints' => [
                    new Assert\NotBlank(message: 'Le montant est obligatoire.'),
                    new Assert\Type(type: 'numeric', message: 'Le montant doit être numérique.'),
                ],
            ])
            ->add('conditionsContrat', TextareaType::class, [
                'label' => 'Conditions du contrat',
                'constraints' => [
                    new Assert\NotBlank(message: 'Les conditions du contrat sont obligatoires.'),
                    new Assert\Length(
                        max: 400,
                        maxMessage: 'Les conditions ne doivent pas dépasser {{ limit }} caractères.'
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
