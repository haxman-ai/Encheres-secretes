<?php

namespace App\Repository;
use App\Entity\Category;
use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function findPublishedOrClosed(): array
    { 
        return $this->createQueryBuilder('i')
        ->andWhere('i.status IN (:statuses)')
        ->setParameter('statuses',['published','closed'])
        ->getQuery()
        ->getResult();

    }

    public function findByCategory(?Category $category): array
    {
    $qb = $this->createQueryBuilder('i')
        ->andWhere('i.status IN (:statuses)')
        ->setParameter('statuses', ['published', 'closed']);

    if ($category) {
        $qb
            ->join('i.categories', 'c')
            ->andWhere('c = :category')
            ->setParameter('category', $category);
    }

    return $qb->getQuery()->getResult();
    }

    }
