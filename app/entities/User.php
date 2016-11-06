<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Security\IIdentity;

/**
 * @ORM\Entity
 */
class User implements IIdentity
{
    use Identifier;

    const REGISTERED = 'registered';
    const ADMIN = 'admin';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=TRUE)
     */
    protected $password;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $isAdmin = false;

    function getRoles()
    {
        return [$this->isAdmin ? 'admin' : 'registered'];
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return boolean
     */
    public function isIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param boolean $isAdmin
     */
    public function setIsAdmin(bool $isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }
}
