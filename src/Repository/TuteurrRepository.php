<?php

namespace App\Repository;

use App\Entity\Tuteurr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tuteurr|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tuteurr|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tuteurr[]    findAll()
 * @method Tuteurr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TuteurrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tuteurr::class);
    }

    // /**
    //  * @return Tuteurr[] Returns an array of Tuteurr objects
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
    public function findOneBySomeField($value): ?Tuteurr
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
