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
 * @UniqueEntity(fields={"email", "contest"}, message="Sie können nur einmal pro Tag teilnehmen!")
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
     * @Assert\NotBlank(message="Dieser Wert darf nicht leer sein.")
     * @Assert\Email(message="Bitte geben Sie eine korrekte Emailadresse an.")
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(message="Dieser Wert darf nicht leer sein.")
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(message="Dieser Wert darf nicht leer sein.")
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(message="Dieser Wert darf nicht leer sein.")
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank(message="Dieser Wert darf nicht leer sein.")
     * @Assert\Length(
     *     min=4,
     *     max=10,
     *     minMessage = "Bitte geben Sie mindestens {{ limit }} Zeichen an.",
     *     minMessage = "Bitte geben Sie maximal {{ limit }} Zeichen an.",
     *     exactMessage = "Bitte geben Sie eine korrekte Postleitzahl mit {{ limit }} Zeichen an."
     * )
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $providedAnswer;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(message="Dieser Wert darf nicht leer sein.")
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
     * @return string
     */
    public function getProvidedAnswer(): ?string
    {
        return $this->providedAnswer;
    }

    /**
     * @param string $providedAnswer
     */
    public function setProvidedAnswer(?string $providedAnswer): void
    {
        $this->providedAnswer = $providedAnswer;
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
