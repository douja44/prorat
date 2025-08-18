<?php

namespace App\Form;

use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idUser', IntegerType::class, [
                'label' => 'ID Utilisateur'
            ])
            ->add('idoffre', IntegerType::class, [
                'label' => 'ID Offre',
                'disabled' => true,                
            ])
            ->add('idEvent', IntegerType::class, [
                'label' => 'ID Événement'
            ])
            ->add('dateExpiration', TextType::class, [
                'label' => 'Date d\'expiration (jj/mm/aaaa)',
                'attr' => ['placeholder' => 'jj/mm/aaaa']
            ])
            ->add('montant', NumberType::class, [
                'label' => 'Montant'
            ])
            ->add('conditionsContrat', TextareaType::class, [
                'label' => 'Conditions du contrat'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}