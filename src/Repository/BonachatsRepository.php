<?php

namespace App\Repository;

use App\Entity\BonAchats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BonAchats|null find($id, $lockMode = null, $lockVersion = null)
 * @method BonAchats|null findOneBy(array $criteria, array $orderBy = null)
 * @method BonAchats[]    findAll()
 * @method BonAchats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BonachatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BonAchats::class);
    }

    public function findByDate($date){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('b')
            ->from('App\Entity\BonAchats', 'b')
            ->where('b.jour = :date')
            ->setParameter('date', $date);
        return $qb->getQuery()
            ->getResult();
    }
}
