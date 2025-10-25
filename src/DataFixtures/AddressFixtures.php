<?php
namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture implements DependentFixtureInterface{
    private const ADDRESS_REFERENCE = 'Adresse';

    public function load(ObjectManager $manager): void{
        $streets=["1 rue bleu","2 rue rouge", "3 rue violet","4 rue noir"];
        $postalCodes=[01000,02000,03000,04000];
        $cities=["Longwy","Mont-Saint-Martin","Lexy","Mexy"];
        $countries=["France","Chine","Belgique","Luxembourg"];

        foreach ($streets as $key => $street){
            $address=new Address();
            $address->setStreet($street);
            $address->setPostalCode($postalCodes[$key]);
            $address->setCity($cities[$key]);
            $address->setCountry($countries[$key]);

            $address->SetUser($this->getReference("User_".$key,User::class));

            $manager->persist($address);

            $this->addReference(self::ADDRESS_REFERENCE.$key, $address);
        }
        $manager->flush();
    }
    public function getDependencies():array{
        return [UserFixtures::class];
    }
}