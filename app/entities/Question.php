<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;

/**
 * @ORM\Entity
 */
class Question
{
    use Identifier;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $text;

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
    protected $fulltext;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $right;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
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
    public function getFulltext()
    {
        return $this->fulltext;
    }

    /**
     * @param string $fulltext
     */
    public function setFulltext(string $fulltext)
    {
        $this->fulltext = $fulltext;
    }

    /**
     * @return int
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @param int $right
     */
    public function setRight(int $right)
    {
        $this->right = $right;
    }
}
