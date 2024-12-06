<?php

namespace App\Repository;

use App\Entity\Chroma;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chroma>
 */
class ChromaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chroma::class);
    }

    public function add($chroma, $itemInDb){
        $entityManager = $this->getEntityManager();
        $entityManager->persist($chroma);
        $entityManager->flush();   
        $entityManager->refresh($itemInDb);
    }

}
