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

    public function findLockerById($id){
        return $this->createQueryBuilder('l')
            ->join('l.user', 'u')
            ->andWhere('l.id = :id') 
            ->setParameter('id', $id)
            ->orderBy('l.id', 'ASC') 
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getMyLocker(){
        $user = $this->security->getUser();
        return $this->createQueryBuilder('l')
            ->join('l.user', 'u')
            ->andWhere('u.id = :user_id') 
            ->setParameter('user_id', $user->getId())
            ->orderBy('l.id', 'ASC') 
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function createLocker($locker){
        $entityManager = $this->getEntityManager();
        $entityManager->persist($locker);
        $entityManager->flush();   
    }

    public function updateLocker($locker){
        $entityManager = $this->getEntityManager();
        $entityManager->persist($locker);
        $entityManager->flush();
    }

    //    /**
    //     * @return Locker[] Returns an array of Locker objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Locker
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
