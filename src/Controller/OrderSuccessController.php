<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Services\Cart;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    /**
     * @Route("/commande/merci/{checkoutSessionId}", name="order_success")
     */

    public function index(Order $order, Cart $cart, EntityManagerInterface $manager, $checkoutSessionId): Response
    {
        if (!$order || $order->getUser() != $this->getUser()) return $this->redirectToRoute('home');

        Stripe::setApiKey($this->getParameter('stripe_key'));
        $session = Session::retrieve($checkoutSessionId);

        //dd($session->payment_status);

        if ($session->payment_status != "paid") return $this->redirectToRoute('order_cancel', ['checkoutSessionId' => $checkoutSessionId]);

        $cart->remove_cart();
        $order->setStatut(1);

        $manager->flush();

        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
