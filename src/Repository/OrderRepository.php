<?php

namespace App\Repository;

use App\Entity\Order;
use App\Enum\StatusOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function countAll(): int
    {
        return (int) $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countByStatus(?StatusOrder $status=null):int{
        $qb=$this->createQueryBuilder('o')
            ->select('count(o.id)');

        if($status){
            $qb->where('o.status = :status')
                ->setParameter('status',$status);
        }
        return $qb->getQuery()->getSingleScalarResult();
    }
}
