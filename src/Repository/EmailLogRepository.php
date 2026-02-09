<?php

namespace App\Repository;

use App\Entity\EmailLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmailLog>
 */
class EmailLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailLog::class);
    }

    /**
     * @return EmailLog[]
     */
    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.sentAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return EmailLog[]
     */
    public function findByStatus(string $status): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->setParameter('status', $status)
            ->orderBy('e.sentAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return EmailLog[]
     */
    public function findByRecipient(string $email): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.recipientEmail = :email')
            ->setParameter('email', $email)
            ->orderBy('e.sentAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return EmailLog[]
     */
    public function findByType(string $type): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.type = :type')
            ->setParameter('type', $type)
            ->orderBy('e.sentAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array{total: int, sent: int, failed: int}
     */
    public function getStats(): array
    {
        $qb = $this->createQueryBuilder('e');

        $total = (int) (clone $qb)->select('COUNT(e.id)')->getQuery()->getSingleScalarResult();
        $sent = (int) (clone $qb)->select('COUNT(e.id)')->where('e.status = :status')->setParameter('status', EmailLog::STATUS_SENT)->getQuery()->getSingleScalarResult();
        $failed = (int) (clone $qb)->select('COUNT(e.id)')->where('e.status = :status')->setParameter('status', EmailLog::STATUS_FAILED)->getQuery()->getSingleScalarResult();

        return [
            'total' => $total,
            'sent' => $sent,
            'failed' => $failed,
        ];
    }
}
