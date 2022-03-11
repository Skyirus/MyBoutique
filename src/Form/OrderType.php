<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $options['user'];

        $builder
            //->add('field_name')
            ->add('addresses', EntityType::class, [
                //'choice_label' => 'name',
                'choices' => $user->getAddresses(),
                'class' => Address::class,
                'label' => 'Choisissez votre adresse de livraison',
                'multiple' => false,
                'expanded' => true,
            ])

            ->add('transporteurs', EntityType::class, [
                'class' => Carrier::class,
                'label' => 'Choisissez votre transporteur',
                'multiple' => false,
                'expanded' => true,
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Valider ma commande',
                'attr' => [
                    'class' => 'btn btn-success col-12'
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => []
            // Configure your form options here
        ]);
    }
}
