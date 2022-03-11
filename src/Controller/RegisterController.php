<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Services\ServiceMail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegisterController extends AbstractController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, EntityManagerInterface $manager, ServiceMail $mail): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        //dd($user);

        $form->handleRequest($request); // on recupere la requete

        if ($form->isSubmitted() && $form->isValid()) {
            //dump('ok');
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            ));

            $user->setActive(false);

            $manager->persist($user); // on persiste les données dans le temps
            $manager->flush(); // on ecris en bdd

            //vérification email d'user
            $token = sha1($user->getEmail());

            //envoi du mail au utilisateur de la creation de son compte
            $content_mail = 'Merci de votre inscription sur le site, pour activer votre compte veillez cliquer sur le lien suivant: <br>
            <a href="http://' . $_SERVER['HTTP_HOST'] . '/inscription/' . $user->getEmail() . '/' . $token . '"></a>';

            //$mail->sendMail($content_mail, $user->getEmail(), $user->getFullName(), 'Inscription sur le site de MyBoutique');
            mail($user->getEmail(), 'Inscription sur le site MyBoutique', $content_mail);

            $this->addFlash(
                'success',
                'Le compte ' . $user->getFirstName() . ' ' . $user->getLastName() . ' a été créé et un mail d\'activation a été envoyé'
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/inscription/{email}/{token}", name="activation_compte")
     */
    public function activation_compte(EntityManagerInterface $manager, User $user, $token): Response
    {

        //dd($user);

        $token_verif = sha1($user->getEmail());

        if ($token_verif == $token) {
            $user->setActive(true);

            $manager->flush();

            $this->addFlash(
                'success',
                'Le compte est activé avec succes'
            );
            return $this->redirectToRoute('app_login');
        } else {
            $this->addFlash(
                'danger',
                'Le lien d\'activation est incorrect'
            );
            return $this->redirectToRoute('home');
        }
    }
}
