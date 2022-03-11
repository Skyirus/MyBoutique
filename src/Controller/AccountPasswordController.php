<?php

namespace App\Controller;

use App\Form\UpdatePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
    /**
     * @Route("/compte/modification-mot-de-passe", name="account_password")
     */
    public function index(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UpdatePasswordType::class, $user);
        //dd($user);

        $form->handleRequest($request); // on recupere la requete

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$passwordHasher->isPasswordValid($user, $user->getOldPassword())) {
                $this->addFlash(
                    'danger',
                    'L\'ancien mot de passe est incorrect'
                );
            } else {
                $user->setPassword($passwordHasher->hashPassword(
                    $user,
                    $user->getNewPassword()
                ));

                $manager->persist($user); // on persiste les données dans le temps
                $manager->flush(); // on ecris en bdd

                $this->addFlash(
                    'success',
                    'Le mot de passe a été mis à jour'
                );

                return $this->redirectToRoute('account');
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
