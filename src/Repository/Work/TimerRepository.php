<?php

namespace App\Repository\Work;

use App\Entity\Work\Timer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Timer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Timer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Timer[]    findAll()
 * @method Timer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Timer::class);
    }

    public function findOneById(int $id): ? Timer
    {
        $this->find($id);
    }
}
