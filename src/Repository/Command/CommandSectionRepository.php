<?php

namespace App\Repository\Command;

use App\Entity\Command\CommandSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandSection[]    findAll()
 * @method CommandSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandSection::class);
    }

    public function findOneById(int $id): ?CommandSection
    {
        return $this->find($id);
    }
}
