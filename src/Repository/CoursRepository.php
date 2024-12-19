<?php
namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    // Méthode pour trouver tous les cours d'un professeur
    public function findByProfesseur($professeurId)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.professeur = :professeurId')
            ->setParameter('professeurId', $professeurId)
            ->getQuery()
            ->getResult();
    }

    // Méthode pour trouver tous les cours d'une classe
    public function findByClasse($classeId)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.classes', 'cl')
            ->andWhere('cl.id = :classeId')
            ->setParameter('classeId', $classeId)
            ->getQuery()
            ->getResult();
    }
}
