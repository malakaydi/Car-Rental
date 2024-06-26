<?php

namespace App\Repository;

use App\Entity\Vidange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vidange>
 *
 * @method Vidange|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vidange|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vidange[]    findAll()
 * @method Vidange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VidangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vidange::class);
    }

//    /**
//     * @return Vidange[] Returns an array of Vidange objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vidange
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
