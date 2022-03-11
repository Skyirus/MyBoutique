<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Votre prénom']])
            ->add('lastName', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Votre nom']])
            ->add('email', EmailType::class)
            //->add('roles')
            ->add('password', PasswordType::class)
            ->add('confirmPassword', PasswordType::class, ['label' => false, 'attr' => ['placeholder' => 'Confirmer votre mot de pass']])
            ->add('submit', SubmitType::class, ['label' => 'Inscription', 'attr' => ['class' => 'col-12 btn-primary']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['registration']
        ]);
    }
}
