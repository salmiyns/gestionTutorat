<?php

namespace App\Repository;

use App\Entity\Tutore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tutore|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tutore|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tutore[]    findAll()
 * @method Tutore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TutoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tutore::class);
    }

    // /**
    //  * @return Tutore[] Returns an array of Tutore objects
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
    public function findOneBySomeField($value): ?Tutore
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
