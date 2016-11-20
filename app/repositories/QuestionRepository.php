<?php

namespace App\Repositories;

use App\Entities\Question;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Tracy\Debugger;

class QuestionRepository
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
     * @var TestRepository
     */
    private $testRepository;

    /**
     * QuestionRepository constructor.
     *
     * @param EntityManager $entityManager
     * @param TestRepository $testRepository
     */
    public function __construct(EntityManager $entityManager, TestRepository $testRepository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Question::class);
        $this->testRepository = $testRepository;
    }

    /**
     * @param array $options
     * @return Question|null
     */
    public function findOneBy(array $options)
    {
        return $this->repository->findOneBy($options);
    }

    /**
     * @param $id
     * @return Question|null
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $options
     * @return Question[]|null
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

    /**
     * @param $values
     * @return Question
     */
    public function saveFormData($values)
    {
        $question = NULL;

        if (isset($values->id)) {
            $question = $this->find($values->id);
        }

        if ( ! $question) {
            $question = new Question();
        }

        $question->setQuestion($values->question);
        $question->setFirst($values->answer1);
        $question->setSecond($values->answer2);
        $question->setThird($values->answer3);
        $question->setFulltextAnswer($values->fulltextAnswer);
        $question->setCorrect($values->correct);
        $question->setTest($this->testRepository->find($values->test));

        $this->entityManager->persist($question);
        $this->entityManager->flush();

        return $question;
    }
}
