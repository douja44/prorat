<?php

namespace App\Form;

use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('user', UserType::class, [
            'label' => false,
            'is_edit' => $options['is_edit'], // 👈 pass option to UserType
          ])
            ->add('type_service', TextType::class, [
                'label' => 'Domaine de travail',
                'attr' => ['class' => 'form-control']
            ])
            ->add('site_web', UrlType::class, [ // Fixed: URL type for websites
                'label' => 'Site Web',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nbre_contacts', IntegerType::class, [ // Fixed: Integer type for numbers
                'label' => 'Nombre de contacts',
                'attr' => ['class' => 'form-control']
            ]);
        
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
            'is_edit' => false, // default is "create" mode
          ]);
    }
}
