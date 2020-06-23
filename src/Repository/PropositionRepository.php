<?php

namespace App\Repository;

use App\Entity\Proposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Proposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proposition[]    findAll()
 * @method Proposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proposition::class);
    }

    // /**
    //  * @return Proposition[] Returns an array of Proposition objects
    //  */
    
    public function findByStatut($value ,$userId)
    {
        return $this->createQueryBuilder('p')
        ->addSelect('user.id as PropositionUserId, user.firstName as CreatedBy_firstName,user.lastName as CreatedBy_lastName , p.id	, p.titre	, p.description , p.date_creation as dateCreation, p.statut')
            ->leftJoin('p.tuteur', 'tuteur') 
            ->leftJoin('tuteur.IdEtudiant', 'etudiant')   
            ->leftJoin('etudiant.idUser', 'user')   
            ->andWhere('p.statut = :val AND user.id = :userID')
            ->setParameter('val', $value)
            ->setParameter('userID', $userId )
            ->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOnlyByStatut($value)
    {
        return $this->createQueryBuilder('p')
        ->addSelect('user.id as PropositionUserId, user.firstName as CreatedBy_firstName,user.lastName as CreatedBy_lastName , p.id	, p.titre	, p.description , p.date_creation as dateCreation, p.statut')
            ->leftJoin('p.tuteur', 'tuteur') 
            ->leftJoin('tuteur.IdEtudiant', 'etudiant')   
            ->leftJoin('etudiant.idUser', 'user')   
            ->andWhere('p.statut = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    


    // /**
    //  * @return Proposition[] Returns an array of Proposition objects
    //  */
    
    public function getWithSearchQueryBuilder_withStatus($value,?string $term): QueryBuilder
    {   
         $qb = $this->createQueryBuilder('p')
        ->addSelect('user.id as PropositionUserId, user.firstName as CreatedBy_firstName,user.lastName as CreatedBy_lastName , p.id	, p.titre	, p.description , p.date_creation as dateCreation, p.statut')
        ->leftJoin('p.tuteur', 'tuteur') 
        ->leftJoin('tuteur.IdEtudiant', 'etudiant')   
        ->leftJoin('etudiant.idUser', 'user')     
        ->andWhere('p.statut = :val')
        ->setParameter('val', $value)
        ;
        if ($term) {
            $qb->andWhere(' p.titre LIKE :term OR p.description LIKE :term OR p.statut LIKE :term')
                ->setParameter('term', '%' . $term . '%')
            ;
        }

        return $qb
            ->orderBy('p.date_creation', 'DESC')
            
            
        ;
    }

    public function getByUserWithSearchQueryBuilder_withStatus($userId,$value,?string $term): QueryBuilder
    {   
         $qb = $this->createQueryBuilder('p')
        ->addSelect('user.id as PropositionUserId, user.firstName as CreatedBy_firstName,user.lastName as CreatedBy_lastName , p.id	, p.titre	, p.description , p.date_creation as dateCreation, p.statut')
        ->leftJoin('p.tuteur', 'tuteur') 
        ->leftJoin('tuteur.IdEtudiant', 'etudiant')   
        ->leftJoin('etudiant.idUser', 'user')     
        ->andWhere('p.statut = :val')
        ->setParameter('val', $value)
        ->andWhere('user.id = :userId')
        ->setParameter('userId', $userId)
        ;
        if ($term) {
            $qb->andWhere(' p.titre LIKE :term OR p.description LIKE :term OR p.statut LIKE :term')
                ->setParameter('term', '%' . $term . '%')
            ;
        }

        return $qb
            ->orderBy('p.date_creation', 'DESC')
            
            
        ;
    }
   
   
    /**
     * @return Proposition[]
     */

    public function findPropositionByTuteurId_qb($tuteur):QueryBuilder
    {
         
        $qb= $this->createQueryBuilder('p')
            //->addSelect('t.id')
            ->leftJoin('p.tuteur', 'tuteur')   
           // ->leftJoin('tuteur.IdEtudiant', 'etudiant')   
           // ->leftJoin('etudiant.UserId', 'user')     
           ->andWhere('p.tuteur= :val')
           ->setParameter('val', $tuteur)
            ->orderBy('p.id', 'ASC')
            //->setMaxResults(1)
            //->getQuery()
            //->getResult()
        ;

        return $qb;
         
    }


        /**
     * @return Proposition[]
     */

    public function findPropositionByTuteurId($tuteur)
    {
         
        return  $this->createQueryBuilder('p')
            //->addSelect('t.id')
            ->leftJoin('p.tuteur', 'tuteur')   
           // ->leftJoin('tuteur.IdEtudiant', 'etudiant')   
           // ->leftJoin('etudiant.UserId', 'user')     
           ->andWhere('p.tuteur= :val')
           ->setParameter('val', $tuteur)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
        ;

         
         
    }

    /*
    public function findOneBySomeField($value): ?Proposition
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
