<?php

namespace App\DataFixtures;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderItemFixtures extends Fixture implements DependentFixtureInterface{
    private const ORDERITEM_REFERENCE = 'OrderItem';

    public function load(ObjectManager $manager):void{
        $orderItem=[
            ['quantity'=>3,'product_ref'=>"Product_0",'order_ref'=>"Order_0"],
            ['quantity'=>2,'product_ref'=>"Product_1",'order_ref'=>"Order_1"],
            ['quantity'=>1,'product_ref'=>"Product_0",'order_ref'=>"Order_2"],
            ['quantity'=>1,'product_ref'=>"Product_2",'order_ref'=>"Order_2"],
            ['quantity'=>5,'product_ref'=>"Product_5",'order_ref'=>"Order_3"],
        ];

        foreach ($orderItem as $key => $item){
            $orderItem = new OrderItem();

            $orderItem->setQuantity($item['quantity']);

            $produit = $this->getReference($item['product_ref'], Product::class);
            $order= $this->getReference($item['order_ref'],Order::class);
            $orderItem->setProduct($produit);
            $orderItem->setOrders($order);

            $orderItem->setProductPrice($produit->getPrice());


            $manager->persist($orderItem);

            $this->addReference(self::ORDERITEM_REFERENCE.'_'.$key, $orderItem);

        }

        $manager->flush();
    }

    public function getDependencies():array{
        return [ProductFixtures::class, OrderFixtures::class];
    }
}
