<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        $user=$this->getUser();

        if($user&&in_array('ROLE_ADMIN', $user->getRoles(),true)){
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('login/user.html.twig');
    }
}
