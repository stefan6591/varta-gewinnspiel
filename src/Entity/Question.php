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
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    const TYPE_RADIO = 1;
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
     * @ORM\Column(type="string", length=2048)
     * @Assert\NotBlank(message="Dieses Feld darf nicht leer sein.", groups={"regular"})
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="question_type", type="integer", options={"default" : 1})
     */
    private $type = self::TYPE_RADIO;

    /**
     * @ORM\OneToOne(targetEntity="Contest", mappedBy="question")
     */
    private $contest;

    /**
     * @var ArrayCollection()
     *
     * @ORM\OneToMany(targetEntity="QuestionAnswer", mappedBy="question", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $answers;

    use TimestampableEntity;

    /**
     * Contest constructor.
     */
    public function __construct() {
        $this->answers = new ArrayCollection();
    }

    /**
     * @param QuestionAnswer $answer
     * @return $this
     */
    public function addAnswer(QuestionAnswer $answer)
    {
        $this->answers->add($answer);

        return $this;
    }

    /**
     * @param QuestionAnswer $answer
     * @return $this
     */
    public function removeAnswer(QuestionAnswer $answer)
    {
        $this->answers->removeElement($answer);

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
     * @return Contest
     */
    public function getContest(): ?Contest
    {
        return $this->contest;
    }

    /**
     * @param Contest $contest
     */
    public function setContest(?Contest $contest): void
    {
        $this->contest = $contest;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnswers(): ArrayCollection
    {
        return $this->answers;
    }

    /**
     * @param ArrayCollection $answers
     */
    public function setAnswers(ArrayCollection $answers): void
    {
        $this->answers = $answers;
    }
}
