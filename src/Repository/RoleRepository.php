<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    public function findOneById(int $id): Role
    {
        return (
            $this->findOneBy(['id' => $id])
            ?? throw new EntityNotFoundException("Role with id [$id] do not exists!")
        );
    }

    public function findOneByCode(string $code): Role
    {
        return (
            $this->findOneBy(['code' => $code])
            ?? throw new EntityNotFoundException("Role with code [$code] do not exists!")
        );
    }
}
