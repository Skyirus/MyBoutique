<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('email')
            //->add('roles')
            //->add('password')
            //->add('firstName')
            //->add('lastName')
            //->add('active')
            ->add('newPassword', PasswordType::class, ['label' => false, 'attr' => ['placeholder' => 'Nouveau mot de pass']])
            ->add('confirmNewPassword', PasswordType::class, ['label' => false, 'attr' => ['placeholder' => 'Confirmer nouveau mot de pass']])
            ->add('submit', SubmitType::class, ['label' => 'Modifier le mot de pass']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
