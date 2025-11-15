<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    #[Route('/order', name: 'seeOrder')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders=$orderRepository->findAll();
        return $this->render('admin/seeOrder.html.twig', [
            'orders' => $orders,
        ]);
    }
}
