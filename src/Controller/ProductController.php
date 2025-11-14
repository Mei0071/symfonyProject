<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: '')]

final class ProductController extends AbstractController
{
    #[Route('/vent', name: 'product_vent')]
    public function listeVent(ProductRepository $productRepository): Response
    {
        $categoryNames = ['Flute'];
        $products = $productRepository->getProductsByCategories($categoryNames);


        return $this->render('product/vent_liste.html.twig', [
            'groupedProducts' => $products,
        ]);
    }

    #[Route('/corde', name: 'product_corde')]
    public function listeCorde(ProductRepository $productRepository): Response
    {
        $categoryNames = ['Violon', 'Guitare'];
        $products = $productRepository->getProductsByCategories($categoryNames);


        return $this->render('product/corde_liste.html.twig', [
            'groupedProducts' => $products,
        ]);
    }

    #[Route('/percussion', name: 'product_percussion')]
    public function listePercussion(ProductRepository $productRepository): Response
    {
        $categoryNames = ['Batterie'];
        $products = $productRepository->getProductsByCategories($categoryNames);

        return $this->render('product/percussion_liste.html.twig', [
            'groupedProducts' => $products,
        ]);
    }
}
