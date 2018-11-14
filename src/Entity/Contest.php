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
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $date;

    /**
     * @var ArrayCollection()
     *
     * @ORM\OneToMany(targetEntity="ContestParticipant", mappedBy="contest")
     */
    private $participants;

    use TimestampableEntity;

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
     * Contest constructor.
     */
    public function __construct() {
        $this->participants = new ArrayCollection();
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
