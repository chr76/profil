<?php

namespace App\Repository;

use App\Entity\Knowledge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Knowledge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Knowledge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Knowledge[]    findAll()
 * @method Knowledge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KnowledgeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Knowledge::class);
    }

    /**
     * @return Knowledge[] Returns an array of Knowledge objects
     */
    public function findAllIndexed()
    {
        return $this->createQueryBuilder('k','k.id')
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Knowledge
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
