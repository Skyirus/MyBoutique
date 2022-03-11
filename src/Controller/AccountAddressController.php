<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    /**
     * @Route("/compte/adresses", name="account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig', [
            'controller_name' => 'AccountAddressController',
        ]);
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_address_add")
     */
    public function add(Request $request, EntityManagerInterface $manager): Response
    {

        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        //dd($user);

        $form->handleRequest($request); // on recupere la requete

        if ($form->isSubmitted() && $form->isValid()) {

            $address->setUser($this->getUser());

            $manager->persist($address);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'adresse a bien été enregistrée'
            );

            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_address_edit")
     */
    public function edit(Request $request, EntityManagerInterface $manager, Address $address, Cart $cart): Response
    {

        // si il y a des produits dans le panier
        if ($cart->get_cart()) {
            return $this->redirectToRoute('order');
        } else {
            return $this->redirectToRoute('account_address');
        }
        
        // dd($address->getUser());

        if ($address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request); // on recupere la requete

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();

            $this->addFlash(
                'success',
                'L\'adresse a bien été modifiée'
            );

            return $this->redirectToRoute('account_address');
        }


        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_address_delete")
     */
    public function delete(EntityManagerInterface $manager, Address $address): Response
    {
        if ($address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }

        $manager->remove($address);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\'adresse a bien été supprimée'
        );


        return $this->redirectToRoute('account_address');
    }
}
