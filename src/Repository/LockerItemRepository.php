<?php

namespace App\Repository;

use App\Entity\LockerItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LockerItem>
 */
class LockerItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LockerItem::class);
    }

    public function add($lockerItem)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($lockerItem);
        $entityManager->flush();
    }

    public function update($lockerItem)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($lockerItem);
        $entityManager->flush();
    }

    public function remove($lockerItem)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($lockerItem);
        $entityManager->flush();
    }

    public function get($lockerItemId)
    {
        return $this->createQueryBuilder('l')
            ->join('l.chroma', 'c')
            ->andWhere('l.id = :val')
            ->setParameter('val', $lockerItemId)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getByItemId($itemId)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.item = :val')
            ->setParameter('val', $itemId)
            ->getQuery()
            ->getResult();
    }
}
