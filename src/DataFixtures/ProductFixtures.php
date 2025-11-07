<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Enum\StatusOrder;
use App\Enum\StatusProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['name' => 'Violon', 'price' => 1500, 'description' => 'Violon...', 'stock' => 10, 'category_ref' => 'Category_0','status' => StatusProduct::Disponible],
            ['name' => 'Guitare acoustique', 'price' => 3000, 'description' => 'Guitare ...', 'stock' => 5, 'category_ref' => 'Category_1','status' => StatusProduct::Disponible],
            ['name' => 'Batterie complète', 'price' => 3500, 'description' => 'Batterie ...', 'stock' => 2, 'category_ref' => 'Category_2','status' => StatusProduct::Disponible],
        ];

        foreach ($products as $prod) {
            $product = new Product();
            $product->setName($prod['name']);
            $product->setPrice($prod['price']);
            $product->setDescription($prod['description']);
            $product->setStock($prod['stock']);
            $product->setStatus($prod['status']);

            $category = $this->getReference($prod['category_ref'], Category::class);
            $product->setCategory($category);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
