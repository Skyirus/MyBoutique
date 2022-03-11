<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountOrderController extends AbstractController
{
    /**
     * @Route("/compte/mes-commandes", name="account_order")
     */
    public function index(OrderRepository $repo): Response
    {



        return $this->render('account/order.html.twig', [
            'orders' => $repo->findSucessOrder($this->getUser()) // on crée une variable 'orders' et on va lui utiliser de côté twig 
        ]);
    }

    /**
     * @Route("/compte/mes-commandes/{reference}", name="account_order_show")
     */
    public function show(Order $order): Response
    {

        if ($order->getUser() != $this->getUser()) return $this->redirectToRoute('account_order');

        return $this->render('account/show.html.twig', [
            'order'=>$order
        ]);
    }
}
