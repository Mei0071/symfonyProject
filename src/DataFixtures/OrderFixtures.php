<?php
namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\User;
use App\Enum\StatusOrder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface{
    private const ORDER_REFERENCE = 'Order';

    public function load(ObjectManager $manager): void{
        $references=["ab15d","asad14","azda4"];
        $createAt=[new \DateTime("now"),new \DateTime("2024-10-09"),new \DateTime("now")];
        $status=[StatusOrder::Preparation,StatusOrder::Annuler,StatusOrder::Expedier];

        foreach ($references as $key => $reference){
            $order=new Order();
            $order->setReference($reference);
            $order->setStatus($status[$key]);
            $order->setCreateAt($createAt[$key]);

            $order->SetUser($this->getReference("User_".$key,User::class));

            $manager->persist($order);

            $this->addReference(self::ORDER_REFERENCE.$key, $order);
        }
        $manager->flush();
    }
    public function getDependencies():array{
        return [UserFixtures::class];
    }
}