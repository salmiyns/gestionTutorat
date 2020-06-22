<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }



    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder2(?string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('u');

        if ($term) {
            $qb->andWhere('u.firstName LIKE :term OR u.lastName LIKE :term OR u.email LIKE :term   ')
                ->setParameter('term', '%' . $term . '%')
            ;
        }

        return $qb
            ->orderBy('u.createdAt', 'DESC')
        ;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

     /**
     * @return User[] Returns an array of User objects     
   
     **/

     
    public function getWithSearchQueryBuilder($term): QueryBuilder
    {   
         $qb = $this->createQueryBuilder('u')
       
        ;
        if ($term) {
            $qb->andWhere(' u.email LIKE :term OR u.description LIKE :term OR u.firstname LIKE :u.firstname  OR u.lastname LIKE :u.lastname   OR u.date_of_birth LIKE :u.date_of_birth  OR u.isVerified LIKE :u.isVerified  OR u.createdAt LIKE :u.createdAt')
                ->setParameter('term', '%' . $term . '%')
            ;
        }

        return $qb
            ->orderBy('u.createdAt', 'DESC')
            
            
        ;
    }

}
