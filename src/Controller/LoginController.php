<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'login' )]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('login/login.html.twig', [
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'register' )]
    public function indexRegister(Request $request,UserRepository $userRepository, UserPasswordHasherInterface $PasswordHasher): Response{
        if($request->isMethod('POST')){
            $email=$request->request->get('_mail');
            $password=$request->request->get('_password');
            $firstName=$request->request->get('_fName');
            $lastName=$request->request->get('_lName');

            $user=new User;
            $user->setEmail($email);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setPassword($PasswordHasher->hashPassword($user,$password));
            $user->setRoles(['ROLE_USER']);

            $userRepository->save($user,true);

            return $this->redirectToRoute('login');
        }


        return $this->render('login/register.html.twig');
    }


}
