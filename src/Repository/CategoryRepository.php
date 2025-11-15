<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }
    public function createCategory(array $data, bool $flush = true): Category
    {
        $category = new Category();
        $category->setName($data['_name']);
        $category->setDescription($data['_description']);

        $this->save($category, $flush);

        return $category;
    }

    public function save(Category $category, bool $flush=true):void
    {
        $this->getEntityManager()->persist($category);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
