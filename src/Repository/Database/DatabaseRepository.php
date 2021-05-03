<?php

namespace App\Repository\Database;

use App\Entity\Database\Database;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Database|null find($id, $lockMode = null, $lockVersion = null)
 * @method Database|null findOneBy(array $criteria, array $orderBy = null)
 * @method Database[]    findAll()
 * @method Database[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatabaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Database::class);
    }

    public function getLastByNumber(int $number): array
    {
        return $this->createQueryBuilder('d')
                    ->setMaxResults($number)
                    ->getQuery()
                    ->getResult();
    }
}
