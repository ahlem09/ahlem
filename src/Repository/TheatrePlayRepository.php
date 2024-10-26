<?php

namespace App\Repository;

use App\Entity\TheatrePlay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TheatrePlayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TheatrePlay::class);
    }

    public function totalNumber($id)
    {
        // Créer une requête DQL pour compter le nombre de spectacles
        $query = $this->getEntityManager()->createQuery(
            'SELECT COUNT(s.id) 
            FROM App\Entity\Show s 
            WHERE s.theatrePlay = :theatrePlayId'
        )->setParameter('theatrePlayId', $id);

        return $query->getSingleScalarResult(); // Retourne le résultat sous forme de nombre
    }
}