<?php

namespace App\Repository;

use App\Entity\Playground;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Playground|null find($id, $lockMode = null, $lockVersion = null)
 * @method Playground|null findOneBy(array $criteria, array $orderBy = null)
 * @method Playground[]    findAll()
 * @method Playground[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaygroundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playground::class);
    }

    // /**
    //  * @return Playground[] Returns an array of Playground objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Playground
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
