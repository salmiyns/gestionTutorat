<?php

namespace App\Repository;

use App\Entity\Tuteur;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tuteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tuteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tuteur[]    findAll()
 * @method Tuteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TuteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tuteur::class);
    }

    
    //  * @return Tuteur[] Returns an array of Tuteur objects
    //  */
  
    public function findByConnectedUserId($userId)
    
    {
         
        return $this->createQueryBuilder('t')
            //->addSelect('t.id')
            ->leftJoin('t.IdEtudiant', 'etudiant')   
            ->leftJoin('etudiant.UserId', 'user')     
           ->andWhere('user.id= :val')
           ->setParameter('val', $userId)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
         
    }
    
    
    public function findByConnectedUserId_Byqb($userId): QueryBuilder
    {
         
        $qb= $this->createQueryBuilder('t')
            //->addSelect('t.id')
            ->leftJoin('t.IdEtudiant', 'etudiant')   
            ->leftJoin('etudiant.UserId', 'user')     
           ->andWhere('user.id= :val')
           ->setParameter('val', $userId)
            ->orderBy('t.id', 'ASC')
           // ->setMaxResults(1)
            //->getQuery()
            //->getResult()
        ;
        return $qb;
    }
    // /**
    //  * @return Tuteur[] Returns an array of Tuteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    // /**
    //  * @return Tuteur[] Returns an array of Tuteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tuteur
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
