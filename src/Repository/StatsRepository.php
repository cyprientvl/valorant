<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;

class StatsRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function findMostUsedSkins(array $itemTypes): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('i.id, i.displayName, i.displayIcon, COUNT(li.id) as useCount')
            ->from('App\Entity\Item', 'i')
            ->join('App\Entity\LockerItem', 'li', 'WITH', 'li.item = i.id')
            ->where('i.itemType IN (:types)')
            ->setParameter('types', $itemTypes)
            ->groupBy('i.id')
            ->orderBy('useCount', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findMostUsedWeaponChromas(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('c.id, c.displayName, c.displayIcon, COUNT(li.id) as useCount')
            ->from('App\Entity\Chroma', 'c')
            ->join('App\Entity\LockerItem', 'li', 'WITH', 'li.chroma = c.id')
            ->groupBy('c.id')
            ->orderBy('useCount', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findMostLikedSkinsByLockers(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('i.id, i.displayName, i.displayIcon, COUNT(u.id) as totalLikes')
            ->from('App\Entity\Item', 'i')
            ->join('App\Entity\LockerItem', 'li', 'WITH', 'li.item = i.id')
            ->join('App\Entity\Locker', 'l', 'WITH', 'li.locker = l.id')
            ->join('l.userLikes', 'u')
            ->groupBy('i.id')
            ->orderBy('totalLikes', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUsersWithMostItems(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u.id, u.username, COUNT(li.id) as itemCount')
            ->from('App\Entity\User', 'u')
            ->join('App\Entity\Locker', 'l', 'WITH', 'l.user = u.id')
            ->join('App\Entity\LockerItem', 'li', 'WITH', 'li.locker = l.id')
            ->groupBy('u.id')
            ->orderBy('itemCount', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }
}
