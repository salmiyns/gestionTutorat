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

    
    public function findByUserId($userId)
    {
        return   $this->createQueryBuilder('t')
            ->select('t.id')
            ->leftJoin('t.IdEtudiant', 'etudiant')   
            ->leftJoin('etudiant.idUser', 'user')   
            ->andWhere('user.id = :userID')
             ->setParameter('userID', $userId )
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            //->getSingleResult() 
        ;
       
       

        
    }
    
    /**
     * @return Tuteur[]
     */
    public function findTuteur_qb($userId): QueryBuilder
    {
         
        $qb= $this->createQueryBuilder('t')
        ->select('t')
        ->leftJoin('t.IdEtudiant', 'etudiant')   
        ->leftJoin('etudiant.idUser', 'user')   
        ->andWhere('user.id = :userID')
         ->setParameter('userID', $userId )
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
   
    public function findByExampleField($value) 
    {
        return $this->createQueryBuilder('t')
        ->select('t.id')
            ->leftJoin('t.IdEtudiant', 'etudiant')   
            ->andWhere('etudiant.id = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
            
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
