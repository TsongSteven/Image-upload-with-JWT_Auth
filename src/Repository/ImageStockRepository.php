<?php

namespace App\Repository;

use App\Entity\ImageStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageStock[]    findAll()
 * @method ImageStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageStock::class);
    }

    // /**
    //  * @return ImageStock[] Returns an array of ImageStock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function tagOrName($search_name){

        $qb = $this->createQueryBuilder('c')
        ->leftJoin('c.tags', 'i')
        ->orderBy('c.id', 'ASC')
        ;

    return $qb
        ->andWhere(
            $qb->expr()->orX(
                $qb->expr()->like('c.image_name', ':search_name'),
                $qb->expr()->like('i.tagName', ':search_name'),
            )
        )
            ->setParameter('search_name', "%$search_name%")
            ->getQuery()
            ->getResult()
        ;

    }
    /*
    public function findOneBySomeField($value): ?ImageStock
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
