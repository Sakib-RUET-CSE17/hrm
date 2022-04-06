<?php

namespace App\Repository;

use App\Entity\Payroll;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Payroll|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payroll|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payroll[]    findAll()
 * @method Payroll[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayrollRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payroll::class);
    }

    public function countEmployees(array $employees): int
    {
        return count($employees);
    }

    // public function deleteOldRejected(): int
    // {
    //     return $this->getOldRejectedQueryBuilder()->delete()->getQuery()->execute();
    // }

    // private function getOldRejectedQueryBuilder(): QueryBuilder
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.state = :state_rejected or c.state = :state_spam')
    //         ->andWhere('c.createdAt < :date')
    //         ->setParameters([
    //             'state_rejected' => 'rejected',
    //             'state_spam' => 'spam',
    //             'date' => new \DateTimeImmutable(-self::DAYS_BEFORE_REJECTED_REMOVAL.' days'),
    //         ])
    //     ;
    // }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Payroll $entity, bool $flush = true): void
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
    public function remove(Payroll $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Payroll[] Returns an array of Payroll objects
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
    public function findOneBySomeField($value): ?Payroll
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
