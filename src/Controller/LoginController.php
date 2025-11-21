<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Repository\AddressRepository;
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

    #[Route('/logout', name: 'logout' )]
    public function logout(){}

    #[Route('/register', name: 'register' )]
    public function indexRegister(Request $request,UserRepository $userRepository, UserPasswordHasherInterface $PasswordHasher, AddressRepository $addressRepository): Response{
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

            $street=$request->request->get('_street');
            $postalCode=$request->request->get('_postalCode');
            $city=$request->request->get('_city');
            $country=$request->request->get('_country');

            $address=new Address;
            $address->setStreet($street);
            $address->setPostalCode($postalCode);
            $address->setCity($city);
            $address->setCountry($country);
            $address->setUser($user);

            $addressRepository->save($address,true);

            return $this->redirectToRoute('login');
        }


        return $this->render('login/register.html.twig');
    }


}
