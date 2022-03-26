<?php

namespace App\Repository;

use App\Entity\DeveloperJobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeveloperJobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeveloperJobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeveloperJobs[]    findAll()
 * @method DeveloperJobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloperJobsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeveloperJobs::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DeveloperJobs $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(DeveloperJobs $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
      * @return DeveloperJobs[] Returns an array of DeveloperJobs objects
      */

    public function findByCountDuration($value,$week)
    {
        return $this->createQueryBuilder('d')
            ->select("sum(d.duration) as sumDuration")
            ->andWhere('d.devId = :val')
            ->andWhere('d.week = :val2')
            ->setParameter('val', $value)
            ->setParameter('val2', $week)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getSingleColumnResult();
    }



    // /**
    //  * @return DeveloperJobs[] Returns an array of DeveloperJobs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeveloperJobs
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
