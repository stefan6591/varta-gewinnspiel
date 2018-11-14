<?php

namespace App\Repository;

use App\Entity\Contest;
use App\Entity\ContestParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContestParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContestParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContestParticipant[]    findAll()
 * @method ContestParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contest::class);
    }

    public function findCurrentContest(){

        $now = new \DateTime();
        $qb = $this->createQueryBuilder('c');

        $qb->where('c.date = :date')
            ->setParameter('date', $now->format('Y-m-d'))
        ;

        return $qb->getQuery()->getSingleResult();
    }
}
