<?php

namespace App\Repository;

use App\Entity\Changelog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Changelog>
 */
class ChangelogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Changelog::class);
    }

    /**
     * @return Changelog[]
     */
    public function findAllOrderedByDate(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.date', 'DESC')
            ->addOrderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<string, Changelog[]>
     */
    public function findGroupedByVersion(): array
    {
        $entries = $this->findAllOrderedByDate();
        $grouped = [];

        foreach ($entries as $entry) {
            $grouped[$entry->getVersion()][] = $entry;
        }

        return $grouped;
    }
}
