<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderCancelController extends AbstractController
{
    /**
     * @Route("/order/cancel{checkoutSessionId}", name="order_cancel")
     */
    public function index(Order $order): Response
    {

        if (!$order || $order->getUser() != $this->getUser()) return $this->redirectToRoute('home');

        return $this->render('order_cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}
