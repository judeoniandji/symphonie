<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    // Méthode pour trouver toutes les sessions d'un cours
    public function findByCours($coursId)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.cours = :coursId')
            ->setParameter('coursId', $coursId)
            ->getQuery()
            ->getResult();
    }

    // Méthode pour trouver toutes les sessions d'une date spécifique
    public function findByDate($date)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.date = :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }
}
