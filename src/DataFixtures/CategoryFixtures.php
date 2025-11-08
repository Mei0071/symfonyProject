<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private const CATEGORY_REFERENCE = 'Category';

    public function load(ObjectManager $manager): void
    {
        $categories = [
            ['name' => "Vent", 'description' => "Type d'instrument à vent"],
            ['name' => "Corde", 'description' => "Type d'instrument à corde"],
            ['name' => "Percussion", 'description' => "Type d'instrument à percussion"],
        ];

        foreach ($categories as $key => $data) {
            $category = new Category();
            $category->setName($data['name']);
            $category->setDescription($data['description']);

            $manager->persist($category);

            $this->addReference(self::CATEGORY_REFERENCE . '_' . $key, $category);
        }

        $manager->flush();
    }
}
