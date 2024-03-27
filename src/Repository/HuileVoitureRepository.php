<?php

namespace App\Repository;

use App\Entity\HuileVoiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HuileVoiture>
 *
 * @method HuileVoiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method HuileVoiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method HuileVoiture[]    findAll()
 * @method HuileVoiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HuileVoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HuileVoiture::class);
    }

//    /**
//     * @return HuileVoiture[] Returns an array of HuileVoiture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HuileVoiture
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
