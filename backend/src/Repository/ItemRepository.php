<?php

namespace App\Repository;

use App\Entity\Item;
use App\Entity\User;
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

    public function getQueryByUserAndNamePrefix(User $user, ?string $prefix)
    {
        $qb = $this->createQueryBuilder('i')
            ->where('i.user = :user')
            ->setParameter('user', $user)
            ->orderBy('i.name', 'ASC');

        if ($prefix) {
            $qb->andWhere('i.name LIKE :prefix')
                ->setParameter('prefix', $prefix . '%');
        }

        return $qb->getQuery();
    }
}
