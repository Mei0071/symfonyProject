<?php

namespace App\Repository;

use App\Entity\Product;
use App\Enum\StatusProduct;
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
    public function createProduct(array $data,CategoryRepository $categoryRepository, bool $flush = true): Product
    {
        $product = new Product();
        $product->setName($data['_name']);
        $product->setPrice($data['_price']);
        $product->setDescription($data['_description']);
        $product->setStock($data['_stock']);
        $product->setStatus(StatusProduct::from($data['_status']));
        $category = $categoryRepository->find($data['_category']);
        $product->setCategory($category);

        $this->save($product, $flush);

        return $product;
    }

    public function save(Product $product, bool $flush=true):void
    {
        $this->getEntityManager()->persist($product);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}