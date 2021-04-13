<?php

namespace App\Repository\Database;

use App\Entity\Database\TableFields;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TableFields|null find($id, $lockMode = null, $lockVersion = null)
 * @method TableFields|null findOneBy(array $criteria, array $orderBy = null)
 * @method TableFields[]    findAll()
 * @method TableFields[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableFieldsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TableFields::class);
    }
}
