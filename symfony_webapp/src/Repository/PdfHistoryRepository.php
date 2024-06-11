<?php

namespace App\Repository;

use App\Entity\PdfHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PdfHistory>
 *
 * @method PdfHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdfHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdfHistory[]    findAll()
 * @method PdfHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdfHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PdfHistory::class);
    }

    //    /**
    //     * @return PdfHistory[] Returns an array of PdfHistory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PdfHistory
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
