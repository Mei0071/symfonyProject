<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getProductsByCategories(array $categoryNames): array
    {
        $products = $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->where('c.name IN (:categories)')
            ->setParameter('categories', $categoryNames)
            ->getQuery()
            ->getResult();

        $grouped = [];
        foreach ($products as $product) {
            $catName = $product->getCategory()->getName();
            $grouped[$catName][] = $product;
        }

        return $grouped;
    }
}