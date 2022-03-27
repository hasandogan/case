<?php

namespace App\Repository;

use App\Entity\DeveloperTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeveloperTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeveloperTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeveloperTask[]    findAll()
 * @method DeveloperTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloperTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeveloperTask::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(DeveloperTask $entity, bool $flush = true): void
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
    public function remove(DeveloperTask $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return DeveloperTask[] Returns an array of DeveloperTask objects
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
    //  * @return DeveloperTask[] Returns an array of DeveloperTask objects
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
    public function findOneBySomeField($value): ?DeveloperTask
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
