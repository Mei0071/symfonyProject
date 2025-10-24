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
    public function listeVent(): Response
    {
        return $this->render('product/vent_liste.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/corde', name: 'product_corde')]
    public function listeCorde(): Response
    {
        return $this->render('product/corde_liste.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/percussion', name: 'product_percussion')]
    public function listePercussion(): Response
    {
        return $this->render('product/percussion_liste.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
