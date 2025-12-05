<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\User;
use App\Enum\StatusOrder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    private const ORDER_REFERENCE = 'Order';

    public function load(ObjectManager $manager): void
    {
        $orders = [
            [
                'status' => StatusOrder::Preparation,
                'created_at' => new \DateTime("now"),
                'user_ref' => "User_0"
            ],
            [
                'status' => StatusOrder::Annuler,
                'created_at' => new \DateTime("2024-10-09"),
                'user_ref' => "User_1"
            ],
            [
                'status' => StatusOrder::Preparation,
                'created_at' => new \DateTime("2023-10-09"),
                'user_ref' => "User_3"
            ],
            [
                'status' => StatusOrder::Expedier,
                'created_at' => new \DateTime("2022-10-09"),
                'user_ref' => "User_0"
            ],
            [
                'status' => StatusOrder::Expedier,
                'created_at' => new \DateTime("now"),
                'user_ref' => "User_2"
            ],
            [
                'status' => StatusOrder::Livrer,
                'created_at' => new \DateTime("now"),
                'user_ref' => "User_3"
            ],
            [
                'status' => StatusOrder::Annuler,
                'created_at' => new \DateTime("2022-10-09"),
                'user_ref' => "User_1"
            ],
        ];

        foreach ($orders as $key => $ord) {
            $order = new Order();
            $order->setStatus($ord['status']);
            $order->setCreateAt($ord['created_at']);
            $order->setReference();


            $user = $this->getReference($ord['user_ref'], User::class);
            $order->setUser($user);

            $manager->persist($order);

            $this->addReference(self::ORDER_REFERENCE.'_'.$key, $order);
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
