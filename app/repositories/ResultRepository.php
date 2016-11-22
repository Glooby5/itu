<?php

namespace App\Repositories;

use App\Entities\Result;
use App\Entities\User;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;

class ResultRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * UserRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Result::class);
    }

    /**
     * @param array $options
     * @return User|null
     */
    public function findOneBy(array $options)
    {
        return $this->repository->findOneBy($options);
    }

    /**
     * @param array $options
     * @return User[]|null
     */
    public function findBy(array $options)
    {
        return $this->repository->findBy($options);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}
