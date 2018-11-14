<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContestParticipantRepository")
 * @ORM\Table(name="contest_participant",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="c_p_unique",
 *            columns={"email", "contest_id"})
 *    })
 *
 * @UniqueEntity(fields={"email", "contest"})
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
     * @var string|null
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank()
     */
    private $zipcode;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank()
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
     * @param null|string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param null|string $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param null|string $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return null|string
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    /**
     * @param null|string $zipcode
     */
    public function setZipcode(?string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
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
