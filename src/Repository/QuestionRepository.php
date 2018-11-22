<?php

namespace App\Repository;

use App\Entity\Contest;
use App\Entity\ContestParticipant;
use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContestParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContestParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContestParticipant[]    findAll()
 * @method ContestParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Question::class);
    }
}
