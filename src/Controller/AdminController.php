<?php

namespace App\Controller;

use App\Entity\Product;
use App\Enum\StatusOrder;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders=$orderRepository->findAll();
        return $this->render('login/admin.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/admin', name: 'app_admin')]
    public function orderByStatus(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();

        $totalOrders = $orderRepository->countAll();
        $preparationOrders = $orderRepository->countByStatus(StatusOrder::Preparation);
        $deliveringOrders = $orderRepository->countByStatus(StatusOrder::Expedier);
        $deliveredOrders = $orderRepository->countByStatus(StatusOrder::Livrer);
        $cancelledOrders = $orderRepository->countByStatus(StatusOrder::Annuler);

        return $this->render('login/admin.html.twig', [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'preparationOrders' => $preparationOrders,
            'deliveringOrders' => $deliveringOrders,
            'deliveredOrders' => $deliveredOrders,
            'cancelledOrders' => $cancelledOrders,
        ]);
    }
}
