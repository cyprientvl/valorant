<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;

class StatsRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function findMostUsedSkins(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('i.id, i.displayName, i.displayIcon, COUNT(li.id) as useCount')
            ->from('App\Entity\Item', 'i')
            ->join('App\Entity\LockerItem', 'li', 'WITH', 'li.item = i.id')
            ->where('i.type = :type')
            ->setParameter('type', 'skin')
            ->groupBy('i.id')
            ->orderBy('useCount', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findMostUsedWeaponChromas(): array
    {
        $weaponTypes = [
            "Odin",
            "Ares",
            "Vandal",
            "Bulldow",
            "Phantom",
            "Judge",
            "Bucky",
            "Frenzy",
            "Classic",
            "Ghost",
            "Sheriff",
            "Shorty",
            "Operator",
            "Guardian",
            "Outlaw",
            "Marshal",
            "Spectre",
            "Stinger",
            "Melee"
        ];

        return $this->entityManager->createQueryBuilder()
            ->select('c.id, c.displayName, c.displayIcon, i.type, COUNT(li.id) as useCount')
            ->from('App\Entity\Chroma', 'c')
            ->join('App\Entity\Item', 'i', 'WITH', 'c.item = i.id')
            ->join('App\Entity\LockerItem', 'li', 'WITH', 'li.chroma = c.id')
            ->where('i.type IN (:types)')
            ->setParameter('types', $weaponTypes)
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
            ->select('i.id, i.displayName, i.displayIcon, SUM(l.likes) as totalLikes')
            ->from('App\Entity\Item', 'i')
            ->join('App\Entity\LockerItem', 'li', 'WITH', 'li.item = i.id')
            ->join('App\Entity\Locker', 'l', 'WITH', 'li.locker = l.id')
            ->where('i.type = :type')
            ->setParameter('type', 'skin')
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
            ->select('u.id, u.username, u.avatar, COUNT(li.id) as itemCount')
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
