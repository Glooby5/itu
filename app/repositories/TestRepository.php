<?php

namespace App\Repositories;

use App\Entities\Test;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;

class TestRepository
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
     * TestRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Test::class);
    }

    /**
     * @param array $options
     * @return Test|null
     */
    public function findOneBy(array $options)
    {
        return $this->repository->findOneBy($options);
    }

    /**
     * @param array $options
     * @return Test[]|null
     */
    public function findBy(array $options)
    {
        return $this->repository->findBy($options);
    }

    /**
     * @param $id
     * @return Test|object
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @return Test[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param $values
     * @return Test
     */
    public function saveFormData($values)
    {
        $test = NULL;

        if (isset($values->id)) {
            $test = $this->find($values->id);
        }

        if ( ! $test) {
            $test = new Test();
        }

        $test->setName($values->name);

        $this->entityManager->persist($test);
        $this->entityManager->flush();

        return $test;
    }
}
