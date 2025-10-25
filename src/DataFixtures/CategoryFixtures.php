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
        $names=["violon","guitare","batterie"];
        $descriptions=["Type d'instruùent à corde","Type d'instrument à corde","Type d'instruùent à percussion"];

        foreach ($names as $key => $name) {
            $category = new Category();
            $category->setName($name);
            $category->setDescription($descriptions[$key]);

            $manager->persist($category);

            $this->addReference(self::CATEGORY_REFERENCE . '_' . $key, $category);
        }

        $manager->flush();
    }
}
