<?php
namespace App\Event;

use App\Entity\Contest;
use App\Entity\ContestParticipant;
use Symfony\Component\EventDispatcher\Event;

class ContestParticipationSuccessEvent extends Event
{
    const NAME = 'contest.participation.success';

    protected $participant;

    public function __construct(ContestParticipant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * @return ContestParticipant
     */
    public function getParticipant(): ContestParticipant
    {
        return $this->participant;
    }
}

