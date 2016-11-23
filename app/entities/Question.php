<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * @ORM\Entity(repositoryClass="QuestionRepository")
 */
class Question
{
    use Identifier;

    const FIRST_ANSWER = 1;
    const SECOND_ANSWER = 2;
    const THIRD_ANSWER = 3;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $question;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $first;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $second;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $third;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $fulltextAnswer;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $correct;

    /**
     * @var Test
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="Test")
     */
    protected $test;

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question)
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * @param string $first
     */
    public function setFirst(string $first)
    {
        $this->first = $first;
    }

    /**
     * @return string
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @param string $second
     */
    public function setSecond(string $second)
    {
        $this->second = $second;
    }

    /**
     * @return string
     */
    public function getThird()
    {
        return $this->third;
    }

    /**
     * @param string $third
     */
    public function setThird(string $third)
    {
        $this->third = $third;
    }

    /**
     * @return string
     */
    public function getFulltextAnswer()
    {
        return $this->fulltextAnswer;
    }

    /**
     * @param string $fulltextAnswer
     */
    public function setFulltextAnswer(string $fulltextAnswer)
    {
        $this->fulltextAnswer = $fulltextAnswer;
    }

    /**
     * @return int
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * @param int $correct
     */
    public function setCorrect(int $correct)
    {
        $this->correct = $correct;
    }

    /**
     * @return Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param Test $test
     */
    public function setTest(Test $test)
    {
        $this->test = $test;
    }
}
