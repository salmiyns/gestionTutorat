<?php

namespace App\Repository;

use App\Entity\Realisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Realisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Realisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Realisation[]    findAll()
 * @method Realisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Realisation::class);
    }




    
    public function findByidUser($idUser)
    {
        return $this->createQueryBuilder('r')
       ->addSelect('cours.id as coursId , 
                    cours.nom_cours as nom_cours , 
                    user.id as realisation_idUser,  
                    user.firstName as CreatedBy_firstName,
                    user.lastName as CreatedBy_lastName ,
                    r.id , 
                    r.titre ,
                    r.desicription ,
                    r.date_creation,
                    r.date_fin
                        
       ')

       ->leftJoin('r.tuteur', 'tuteurr') 
       ->leftJoin('r.cours', 'cours') 
       ->leftJoin('tuteurr.etudiant', 'etudiant')   
        ->leftJoin('etudiant.idUser', 'user')   
        ->andWhere(' user.id = :idUser')
        ->setParameter('idUser', $idUser )
        ->orderBy('r.id', 'ASC')
        //->setMaxResults(10)
        ->getQuery()
        ->getResult()
        ;
    }



    public function getRealisation_byUser($idUser)
    {
        $qb = $this->createQueryBuilder('r')
 
       ->leftJoin('r.tuteur', 'tuteurr') 
       ->leftJoin('tuteurr.etudiant', 'etudiant')   
        ->leftJoin('etudiant.idUser', 'user')   
        ->andWhere(' user.id = :idUser')
        ->setParameter('idUser', $idUser )

        ->orderBy('r.id', 'ASC')
        //->setMaxResults(100)
        //->getQuery()
       // ->getResult()
        ;
        return $qb;


    }


 
   
   


    public function findByidUser_qb($idUser):QueryBuilder
    {
        $qb= $this->createQueryBuilder('r')
       /*->addSelect('cours.id as coursId , 
                    cours.nom_cours as nom_cours , 
                    user.id as realisation_idUser,  
                    user.firstName as CreatedBy_firstName,
                    user.lastName as CreatedBy_lastName ,
                    r.id , 
                    r.titre ,
                    r.desicription ,
                    r.date_creation,
                    r.date_fin
                        
       ')*/

       ->leftJoin('r.tuteur', 'tuteurr') 
       ->leftJoin('r.cours', 'cours') 
       ->leftJoin('tuteurr.etudiant', 'etudiant')   
        ->leftJoin('etudiant.idUser', 'user')   
        ->andWhere(' user.id = :idUser')
        ->setParameter('idUser', $idUser )
        ->orderBy('r.id', 'ASC')
        //->setMaxResults(10)
       // ->getQuery()
        //->getResult()
        ;

        return  $qb;


    }
   


    public function findByidUser_currentWeek($idUser): QueryBuilder
    {
        $weekstart = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
        $weekend = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');


        $qb = $this->createQueryBuilder('r')
        ->addSelect('cours.id as coursId , 
        cours.nom_cours as nom_cours , 
        user.id as realisation_idUser,  
        user.firstName as CreatedBy_firstName,
        user.lastName as CreatedBy_lastName ,
        r.id , 
        r.titre ,
        r.desicription ,
        r.date_creation,
        r.date_fin
        ')
       ->leftJoin('r.tuteur', 'tuteurr') 
       ->leftJoin('r.cours', 'cours') 
       ->leftJoin('tuteurr.etudiant', 'etudiant')   
        ->leftJoin('etudiant.idUser', 'user')   
        ->Where(' user.id = :idUser')
        ->setParameter('idUser', $idUser )
        ->andWhere('r.date_fin BETWEEN :dateMin AND :dateMax ')
        ->setParameter('dateMin', $weekstart )
        ->setParameter('dateMax', $weekend )

        
        ->orderBy('r.date_fin', 'ASC')
        //->setMaxResults(10)
       // ->getQuery()
      //  ->getResult()
        ;

        return $qb ;
    }


    // /**
    //  * @return Realisation[] Returns an array of Realisation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Realisation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */





}
