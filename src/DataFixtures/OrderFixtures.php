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
                'reference' => "ab15d",
                'status' => StatusOrder::Preparation,
                'created_at' => new \DateTime("now"),
                'user_ref' => "User_0"
            ],
            [
                'reference' => "asad14",
                'status' => StatusOrder::Annuler,
                'created_at' => new \DateTime("2024-10-09"),
                'user_ref' => "User_1"
            ],
            [
                'reference' => "azda4",
                'status' => StatusOrder::Expedier,
                'created_at' => new \DateTime("now"),
                'user_ref' => "User_2"
            ],
        ];

        foreach ($orders as $key => $data) {
            $order = new Order();
            $order->setReference($data['reference']);
            $order->setStatus($data['status']);
            $order->setCreateAt($data['created_at']);

            /** @var User $user */
            $user = $this->getReference($data['user_ref'], User::class);
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
