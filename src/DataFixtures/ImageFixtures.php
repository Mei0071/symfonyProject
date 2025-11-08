<?php


namespace App\DataFixtures;


use App\Entity\Image;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    private const IMAGE_REFERENCE = 'Image';

    public function load(ObjectManager $manager): void
    {
        $Images = [
            ['url' => "assets/img/imageHeader.jpg", 'product_ref' => "Product_0"],
            ['url' => "assets/img/imageHeader.jpg", 'product_ref' => "Product_1"],
            ['url' => "assets/img/imageHeader.jpg", 'product_ref' => "Product_2"],
        ];

        foreach ($Images as $key => $im) {
            $image = new Image();

            $image->setUrl($im['url']);

            $produit = $this->getReference($im['product_ref'], Product::class);
            $image->setProduct($produit);



            $manager->persist($image);

            $this->addReference(self::IMAGE_REFERENCE . '_' . $key, $image);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProductFixtures::class];
    }
}
