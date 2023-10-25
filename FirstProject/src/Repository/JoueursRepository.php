<?php

namespace App\Repository;

use App\Entity\Joueurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Joueurs>
 *
 * @method Joueurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joueurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joueurs[]    findAll()
 * @method Joueurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoueursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joueurs::class);
    }

//    /**
//     * @return Joueurs[] Returns an array of Joueurs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Joueurs
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
