<?php

namespace App\Repository\Links;

use App\Entity\Links\LinkSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LinkSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkSection[]    findAll()
 * @method LinkSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkSection::class);
    }
}
