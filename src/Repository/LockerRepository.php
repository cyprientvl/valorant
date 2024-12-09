<?php

namespace App\Repository;

use App\Entity\Locker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<Locker>
 */
class LockerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private Security $security)
    {
        parent::__construct($registry, Locker::class);
    }

    public function getLockerByusername($search)
    {
        return $this->createQueryBuilder('l')
            ->join('l.user', 'u')
            ->andWhere('l.isPublic = 1')
            ->andWhere(
                $this->createQueryBuilder('l')
                    ->expr()
                    ->orX(
                        'LOWER(l.name) LIKE LOWER(:search)',
                        'LOWER(u.username) LIKE LOWER(:search)'
                    )
            )
            ->setParameter('search', '%' . $search . '%')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }


    public function findLockerByUserId($userId)
    {
        return $this->createQueryBuilder('l')
            ->join('l.user', 'u')
            ->andWhere('u.id = :user_id')
            ->setParameter('user_id', $userId)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findLockerById($id)
    {
        return $this->createQueryBuilder('l')
            ->join('l.user', 'u')
            ->andWhere('l.id = :id')
            ->setParameter('id', $id)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMyLocker()
    {
        $user = $this->security->getUser();
        return $this->createQueryBuilder('l')
            ->join('l.user', 'u')
            ->andWhere('u.id = :user_id')
            ->setParameter('user_id', $user->getId())
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getTopLocker()
    {
        return $this->createQueryBuilder('l')
            ->join('l.user', 'u')
            ->andWhere('l.isPublic = 1')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }

    public function getTotalLocker()
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getLockerPoduim()
    {
        return $this->createQueryBuilder('l')
            ->join('l.user', 'u')
            ->andWhere('l.isPublic = 1')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }



    public function createLocker($locker)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($locker);
        $entityManager->flush();
    }

    public function updateLocker($locker)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($locker);
        $entityManager->flush();
    }

}
