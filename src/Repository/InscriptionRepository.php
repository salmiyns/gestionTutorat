<?php

namespace App\Repository;

use App\Entity\Inscription;
use App\Entity\Tuteurr;
use App\Entity\Tutoree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscription[]    findAll()
 * @method Inscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscription::class);
    }

     /**
      * @return Inscription[] Returns an array of Inscription objects
     */
    
    public function findByTutoreAndStatut(?Tutoree $tutoree  , ?int $staut )
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.tutore = :tutoree AND i.statut = :statut')
            ->setParameter('statut', $staut)
            ->setParameter('tutoree', $tutoree)
            ->orderBy('i.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByTuteurAndStatut(?Tuteurr $tuteurr  , ?int $staut )
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('i.realisation', 'realisation') 
            ->leftJoin('realisation.tuteur', 'tuteurr')   
            ->andWhere('realisation.tuteur = :tuteurr AND i.statut = :statut')
            ->setParameter('statut', $staut)
            ->setParameter('tuteurr', $tuteurr)
            ->orderBy('i.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
     
     

    /*
    public function findOneBySomeField($value): ?Inscription
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
