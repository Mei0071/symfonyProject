<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    private const ADDRESS_REFERENCE = 'Address';

    public function load(ObjectManager $manager): void
    {
        $addresses = [
            ['street' => "1 rue bleu", 'postal_Code' => 1000, 'city' => "Longwy", 'country' => "France", 'user_ref' => "User_2"],
            ['street' => "2 rue rouge", 'postal_Code' => 2000, 'city' => "Mont-Saint-Martin", 'country' => "Chine", 'user_ref' => "User_1"],
            ['street' => "3 rue violet", 'postal_Code' => 3000, 'city' => "Lexy", 'country' => "Belgique", 'user_ref' => "User_3"],
            ['street' => "4 rue noir", 'postal_Code' => 4000, 'city' => "Mexy", 'country' => "Luxembourg", 'user_ref' => "User_0"],
        ];

        foreach ($addresses as $key => $ad) {
            $address = new Address();
            $address->setStreet($ad['street']);
            $address->setPostalCode($ad['postal_Code']);
            $address->setCity($ad['city']);
            $address->setCountry($ad['country']);

            $user = $this->getReference($ad['user_ref'], User::class);
            $address->setUser($user);

            $manager->persist($address);

            $this->addReference(self::ADDRESS_REFERENCE.'_'.$key, $address);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
