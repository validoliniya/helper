<?php

namespace App\Repository\Command;

use App\Entity\Command\Command;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Command|null find($id, $lockMode = null, $lockVersion = null)
 * @method Command|null findOneBy(array $criteria, array $orderBy = null)
 * @method Command[]    findAll()
 * @method Command[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Command::class);
    }

    public function getLastByNumber(int $number): array
    {
        return $this->createQueryBuilder('c')
                    ->setMaxResults($number)
                    ->getQuery()
                    ->getResult();
    }

    public function findBySectionId(int $id): array
    {
        return $this->createQueryBuilder('c')
                    ->where('IDENTITY(c.section) = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getResult();
    }

    public function getWithSearchBySectionIdQueryBuilder(int $id): QueryBuilder
    {
        return $this->createQueryBuilder('c')
                    ->where('IDENTITY(c.section) = :id')
                    ->setParameter('id', $id);

    }

    public function findOneById(int $id): ?Command
    {
        return $this->findOneBy(['id' => $id]);
    }
}
