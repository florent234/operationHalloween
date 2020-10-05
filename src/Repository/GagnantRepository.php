<?php

namespace App\Repository;

use App\Entity\Gagnant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gagnant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gagnant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gagnant[]    findAll()
 * @method Gagnant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GagnantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gagnant::class);
    }
}
