<?php

namespace App\Form;

use App\Entity\Address;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel nom souhaitez vous donner à votre adresse',
                'attr' => [
                    'placeholder' => 'Nommez votre adresse'
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Quel est votre prénom',
                'attr' => [
                    'placeholder' => 'Prénom'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Quel est votre nom',
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Quel est address de votre entreprise ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisissez l\'adresse de votre entreprise (optionnel)'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Quel est votre address',
                'attr' => [
                    'placeholder' => 'Saissisez votre adress'
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'Quel est le code postal de votre ville',
                'attr' => [
                    'placeholder' => 'Code postal'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Quel est votre ville',
                'attr' => [
                    'placeholder' => 'Ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Quel est votre pays',
                'attr' => [
                    'placeholder' => 'Pays'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Quel est votre téléphone',
                'attr' => [
                    'placeholder' => 'Téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-success col-12'
                ]
            ])
            //->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
