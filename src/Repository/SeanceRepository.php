<?php

namespace App\Repository;

use App\Entity\Seance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Seance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seance[]    findAll()
 * @method Seance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seance::class);
    }

    // /**
    //  * @return Seance[] Returns an array of Seance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findBy_currentWeek() 
    {
        $weekstart = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
        $weekend = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');

        return  $this->createQueryBuilder('s')
            //->andWhere('s.exampleField = :val')
            //->setParameter('val', $value)
            ->andWhere('s.temps BETWEEN :dateMin AND :dateMax ')
            ->setParameter('dateMin', $weekstart )
            ->setParameter('dateMax', $weekend )
            ->orderBy('s.temps', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            
            ;
            
        
    }
    




    public function findBy_currentWeek_qb(): QueryBuilder
    {
        $weekstart = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
        $weekend = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');


        $qb = $this->createQueryBuilder('s')
       ->Select('s.id')
       //->leftJoin('r.tuteur', 'tuteurr') 
      // ->leftJoin('r.cours', 'cours') 
       //->leftJoin('tuteurr.etudiant', 'etudiant')   
       // ->leftJoin('etudiant.idUser', 'user')   
       // ->Where(' user.id = :idUser')
        //->setParameter('idUser', $idUser )
        //->Where('s.temps BETWEEN :dateMin AND :dateMax ')
        //->setParameter('dateMin', $weekstart )
        //->setParameter('dateMax', $weekend )

        
        ->orderBy('s.temps', 'ASC')
        //->setMaxResults(10)
       // ->getQuery()
      //  ->getResult()
        ;

        return $qb ;
    }
}
