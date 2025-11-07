<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private const USER_REFERENCE = 'User';

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $users = [
            ['email' => "client1@orange.fr", 'first_name' => "Jean", 'last_name' => "Jardin", 'roles' => 'admin', 'password' => "123"],
            ['email' => "client2@orange.fr", 'first_name' => "Clara", 'last_name' => "Ciel", 'roles' => 'user', 'password' => "abc"],
            ['email' => "client3@orange.fr", 'first_name' => "Mel", 'last_name' => "Etoile", 'roles' => 'user', 'password' => "def"],
            ['email' => "client4@orange.fr", 'first_name' => "Louis", 'last_name' => "Terre", 'roles' => 'admin', 'password' => "456"],
        ];

        foreach ($users as $key => $us) {
            $user = new User();
            $user->setEmail($us['email']);
            $user->setFirstName($us['first_name']);
            $user->setLastName($us['last_name']);
            $user->setRoles($us['roles']);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $us['password'])
            );

            $manager->persist($user);

            $this->addReference(self::USER_REFERENCE.'_'.$key, $user);
        }

        $manager->flush();
    }
}
