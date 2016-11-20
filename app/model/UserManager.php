<?php

namespace App\Model;

use App\Entities\User;
use App\Repositories\UserRepository;
use Nette;
use Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager implements Nette\Security\IAuthenticator
{
    use Nette\SmartObject;

    const
        TABLE_NAME = 'users',
        COLUMN_ID = 'id',
        COLUMN_NAME = 'username',
        COLUMN_PASSWORD_HASH = 'password',
        COLUMN_EMAIL = 'email',
        COLUMN_ROLE = 'role';

    /**
     * @var UserRepository
     */
    private $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @param array $credentials
     * @return User
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;

        $user = $this->userRepository->findOneBy(['email' => $username]);

        if (!$user) {
            throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

        } elseif (!Passwords::verify($password, $user->getPassword())) {
            throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

        } elseif (Passwords::needsRehash($user->getPassword())) {
            $user->setPassword(Passwords::hash($password));
            $this->userRepository->getEntityManager()->flush();
        }

        return $user;
    }


    /**
     * @param $email
     * @param $password
     * @param null $isAdmin
     * @throws DuplicateNameException
     */
    public function add($email, $password = NULL, $isAdmin = NULL)
    {
        $existingUser = $this->userRepository->findBy(['email' => $email]);

        if ($existingUser) {
            throw new DuplicateNameException;
        }

        $user = new User();
        $user->setEmail($email);

        if ($password) {
            $user->setPassword(Passwords::hash($password));
        }

        if ($isAdmin) {
            $user->setIsAdmin($isAdmin);
        }

        $this->userRepository->getEntityManager()->persist($user);
        $this->userRepository->getEntityManager()->flush();
    }
}



class DuplicateNameException extends \Exception
{}
