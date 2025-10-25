<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher) {}

    private const USER_REFERENCE = 'User';
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager):void
    {
        $mailsUser = ["client1@orange.fr", "client2@orange.fr", "client3@orange.fr", "client4@orange.fr"];
        $prenomsUser = ["Jean", "Clara", "Mel", "Louis"];
        $nomsUser = ["Jardin", "Ciel", "Etoile", "Terre"];
        $rolesUser = ["admin", "client", "client", "client"];
        $passwordsUser = ["123", "abc", "def", "456"];

        foreach ($mailsUser as $key => $mailUser) {
            $user = new User();
            $user->setEmail($mailUser);
            $user->setFirstName($prenomsUser[$key]);
            $user->setLastName($nomsUser[$key]);
            $user->setRoles($rolesUser[$key]);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $passwordsUser[$key])
            );

            $manager->persist($user);

            $this->addReference(self::USER_REFERENCE.'_'.$key, $user);
        }

        $manager->flush();
    }
}
