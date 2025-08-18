<?php
namespace App\Form;

use App\Entity\Organisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\UserType;

class OrganisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserType::class, [
                'label' => false,
                'is_edit' => $options['is_edit'],
                'by_reference' => false, // Important for proper validation
            ])
            ->add('workField', TextType::class, [
                'label' => 'Domaine de travail',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('workEmail', EmailType::class, [
                'label' => 'Email professionnel',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organisateur::class,
            'is_edit' => false,
            'validation_groups' => ['Default'],  // custom option to toggle edit mode if needed
        ]);
    }
}
