<?php

namespace App\Controller;

use App\Repository\HomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{
    #[Route('/', name: 'home')]
    public function index(HomeRepository $homeRepository):Response{
        $categories=$homeRepository->findAllCategories();

        return $this->render('home.html.twig',[
            'categories'=>$categories
        ]);
    }
}