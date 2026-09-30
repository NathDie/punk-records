<?php

namespace App\Repository;

use App\Entity\Reminder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reminder>
 */
class ReminderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reminder::class);
    }

    public function findToday(): array
    {
        $start = new \DateTimeImmutable('today');
        $end = $start->modify('+1 day');

        return $this->createQueryBuilder('r')
            ->andWhere('r.remindAt >= :start')
            ->andWhere('r.remindAt < :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->orderBy('r.remindAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findUpcoming(): array
    {
        $tomorrow = new \DateTimeImmutable('tomorrow');

        return $this->createQueryBuilder('r')
            ->andWhere('r.remindAt >= :tomorrow')
            ->setParameter('tomorrow', $tomorrow)
            ->orderBy('r.remindAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOverdue(): array
    {
        $today = new \DateTimeImmutable('today');

        return $this->createQueryBuilder('r')
            ->andWhere('r.remindAt < :today')
            ->setParameter('today', $today)
            ->orderBy('r.remindAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Reminder[] Returns an array of Reminder objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reminder
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
