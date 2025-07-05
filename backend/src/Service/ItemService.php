<?php

namespace App\Service;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;

class ItemService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function save(Item $item): void
    {
        $this->em->persist($item);
        $this->em->flush();
    }

    public function updateQuantity(Item $item, int $newQuantity): void
    {
        $item->setQuantity($newQuantity);
        $this->em->flush();
    }

    public function delete(Item $item): void
    {
        $this->em->remove($item);
        $this->em->flush();
    }
}