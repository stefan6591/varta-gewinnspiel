<?php

namespace App\Repository;

use App\Entity\ContestParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContestParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContestParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContestParticipant[]    findAll()
 * @method ContestParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContestParticipantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContestParticipant::class);
    }
}
