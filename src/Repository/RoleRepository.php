<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Role>
 */
class RoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    /**
     * Get a map of role code => display name for all roles.
     *
     * @return array<string, Role>
     */
    public function findAllIndexedByCode(): array
    {
        $roles = $this->createQueryBuilder('r')
            ->orderBy('r.sortOrder', 'ASC')
            ->getQuery()
            ->getResult();

        $map = [];
        foreach ($roles as $role) {
            $map[$role->getCode()] = $role;
        }

        return $map;
    }

    /**
     * Get display name map: code => displayName.
     *
     * @return array<string, string>
     */
    public function getDisplayNameMap(): array
    {
        $roles = $this->findAllIndexedByCode();

        $map = [];
        foreach ($roles as $code => $role) {
            $map[$code] = $role->getDisplayName();
        }

        return $map;
    }
}
