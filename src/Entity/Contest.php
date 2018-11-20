<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContestRepository")
 * @UniqueEntity(fields={"date"})
 */
class Contest
{
    const TYPE_DEFAULT = 1;
    const TYPE_ADVENT_CALENDAR = 2;

    public static $types = [
        'Default' => self::TYPE_DEFAULT,
        'Advents Kalender' => self::TYPE_ADVENT_CALENDAR,
    ];

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Dieser Wert darf nicht leer sein.")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, unique=true)
     * @Assert\NotBlank(message="Dieser Wert darf nicht leer sein.")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="contest_type", type="integer", options={"default" : 1})
     */
    private $type = self::TYPE_DEFAULT;

    /**
     * @var Question|null
     *
     * @ORM\OneToOne(targetEntity="Question", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=true)
     */
    private $question;

    /**
     * @var ArrayCollection()
     *
     * @ORM\OneToMany(targetEntity="ContestParticipant", mappedBy="contest")
     */
    private $participants;

    use TimestampableEntity;

    /**
     * Contest constructor.
     */
    public function __construct() {
        $this->participants = new ArrayCollection();
    }

    /**
     * @param ContestParticipant $participant
     * @return $this
     */
    public function addParticipant(ContestParticipant $participant)
    {
        $this->participants->add($participant);

        return $this;
    }

    /**
     * @param ContestParticipant $participant
     * @return $this
     */
    public function removeParticipant(ContestParticipant $participant)
    {
        $this->participants->removeElement($participant);

        return $this;
    }

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Question|null
     */
    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    /**
     * @param Question|null $question
     */
    public function setQuestion(?Question $question): void
    {
        $this->question = $question;
    }

    /**
     * @return Collection
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    /**
     * @param Collection $participants
     */
    public function setParticipants(Collection $participants): void
    {
        $this->participants = $participants;
    }
}
