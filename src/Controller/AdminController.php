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
    public function getGeneralInformations(OrderRepository $orderRepository, ProductRepository $productRepository): Response
    {
        $numberOfProducts=$productRepository->getnumberOfProduct();

        $orders = $orderRepository->lastOrders(5);

        $totalOrders = $orderRepository->countAll();
        $preparationOrders = $orderRepository->countByStatus(StatusOrder::Preparation);
        $deliveringOrders = $orderRepository->countByStatus(StatusOrder::Expedier);
        $deliveredOrders = $orderRepository->countByStatus(StatusOrder::Livrer);
        $cancelledOrders = $orderRepository->countByStatus(StatusOrder::Annuler);

        $totalAmount=$orderRepository->getTotalAmount();

        return $this->render('login/admin.html.twig', [
            'numberOfProducts' => $numberOfProducts,
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'preparationOrders' => $preparationOrders,
            'deliveringOrders' => $deliveringOrders,
            'deliveredOrders' => $deliveredOrders,
            'cancelledOrders' => $cancelledOrders,
            'totalAmount' => $totalAmount
        ]);
    }
    #[Route('/admin/product', name: 'adminProduct')]
    public function allProduct(ProductRepository $productRepository): Response
    {
        $products = $productRepository->getAllProduct();
        return $this->render('admin/product.html.twig', [
            'products' => $products,
        ]);
    }
}
