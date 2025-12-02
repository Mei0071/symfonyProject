<?php

namespace App\Controller;

use App\Entity\Product;
use App\Enum\StatusProduct;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProductController extends AbstractController
{
    #[Route('/products/vent', name: 'product_vent')]
    public function listeVent(ProductRepository $productRepository): Response
    {
        $categoryNames = ['Flute'];
        $products = $productRepository->getProductsByCategories($categoryNames);


        return $this->render('product/vent_liste.html.twig', [
            'groupedProducts' => $products,
        ]);
    }

    #[Route('/products/corde', name: 'product_corde')]
    public function listeCorde(ProductRepository $productRepository): Response
    {
        $categoryNames = ['Violon', 'Guitare'];
        $products = $productRepository->getProductsByCategories($categoryNames);


        return $this->render('product/corde_liste.html.twig', [
            'groupedProducts' => $products,
        ]);
    }

    #[Route('/products/percussion', name: 'product_percussion')]
    public function listePercussion(ProductRepository $productRepository): Response
    {
        $categoryNames = ['Batterie'];
        $products = $productRepository->getProductsByCategories($categoryNames);

        return $this->render('product/percussion_liste.html.twig', [
            'groupedProducts' => $products,
        ]);
    }

    #[Route('/admin/product/new', name: 'addProduct', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', sprintf('Produit "%s" ajouté !', $product->getName()));

            return $this->redirectToRoute('addProduct');
        }

        return $this->render('admin/addProduct.html.twig', [
            'product'=>$product,
            'form'=>$form->createView(),
        ]);
    }

}
