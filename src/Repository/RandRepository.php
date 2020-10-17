<?php

namespace App\Repository;

use App\Entity\Rand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rand[]    findAll()
 * @method Rand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rand::class);
    }

}
