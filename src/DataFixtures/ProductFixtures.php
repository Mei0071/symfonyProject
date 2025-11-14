<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Enum\StatusProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    private const PRODUCT_REFERENCE = 'Product';

    public function load(ObjectManager $manager): void
    {
        $products = [
            ['name' => 'Violon', 'price' => 1500, 'description' => 'Violon...', 'stock' => 10, 'category_ref' => 'Category_0','status' => StatusProduct::Disponible],
            ['name' => 'Guitare acoustique', 'price' => 3000, 'description' => 'Guitare ...', 'stock' => 5, 'category_ref' => 'Category_1','status' => StatusProduct::Disponible],
            ['name' => 'Batterie complète', 'price' => 3500, 'description' => 'Batterie ...', 'stock' => 2, 'category_ref' => 'Category_2','status' => StatusProduct::Disponible],
            ['name' => 'Flutte traversière', 'price' => 3010, 'description' => 'Flute...', 'stock' => 2, 'category_ref' => 'Category_3','status' => StatusProduct::Disponible],
            ['name' => 'Violoncelle', 'price' => 3400, 'description' => 'Violoncelle...', 'stock' => 2, 'category_ref' => 'Category_4','status' => StatusProduct::Disponible],
            ['name' => 'Guitare electrique', 'price' => 2500, 'description' => 'Guitare ...', 'stock' => 5, 'category_ref' => 'Category_1','status' => StatusProduct::Disponible],
        ];

        foreach ($products as $key=>$prod) {
            $product = new Product();
            $product->setName($prod['name']);
            $product->setPrice($prod['price']);
            $product->setDescription($prod['description']);
            $product->setStock($prod['stock']);
            $product->setStatus($prod['status']);

            $category = $this->getReference($prod['category_ref'], Category::class);
            $product->setCategory($category);

            $manager->persist($product);

            $this->addReference(self::PRODUCT_REFERENCE.'_'.$key, $product);
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
