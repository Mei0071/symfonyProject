<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CategoryController extends AbstractController
{
    #[Route('/admin/category/new', name: 'addCategory')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {

        if ($request->isMethod('POST')) {
            $categoryRepository->createCategory($request->request->all());
            $this->addFlash('success', 'Catégorie ajouté !');
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/addCategory.html.twig', [
        ]);
    }
}
