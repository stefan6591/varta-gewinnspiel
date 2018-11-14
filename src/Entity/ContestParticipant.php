<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContestParticipantRepository")
 * @ORM\Table(name="contest_participant",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="c_p_unique",
 *            columns={"email", "contest_id"})
 *    })
 */
class ContestParticipant
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
     * @ORM\Column(type="string", length=180)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $city;

    /**
     * @var Contest
     *
     * @ORM\ManyToOne(targetEntity="Contest", inversedBy="participants")
     */
    private $contest;

    use TimestampableEntity;

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return ContestParticipant
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Contest
     */
    public function getContest(): Contest
    {
        return $this->contest;
    }

    /**
     * @param Contest $contest
     */
    public function setContest(Contest $contest): void
    {
        $this->contest = $contest;
    }
}
