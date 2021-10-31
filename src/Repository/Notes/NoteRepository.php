<?php

namespace App\Repository\Notes;

use App\Entity\Database\Database;
use App\Entity\Notes\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
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
