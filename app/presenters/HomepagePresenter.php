<?php

namespace App\Presenters;

use App\Entities\Result;
use App\Entities\Test;
use App\Entities\User;
use App\Repositories\ResultRepository;
use App\Repositories\TestRepository;
use App\Repositories\UserRepository;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var TestRepository
     * @inject
     */
    public $testRepository;

    /**
     * @var UserRepository
     * @inject
     */
    public $userRepository;

    /**
     * @var ResultRepository
     * @inject
     */
    public $resultRepository;

    public function renderDefault()
    {
        $this->template->test = $this->testRepository->findAll()[0];
    }

    public function handleSubmit($email, $difficulty, $test)
    {
        $filledQuestions = json_decode($test);
        $test = $this->testRepository->findAll()[0];
        $correct = 0;

        foreach ($test->getQuestions() as $i => $question) {

            if ($difficulty == Test::DIFFICULTY_FULLTEXT) {
                if ($question->getFulltextAnswer() == $filledQuestions[$i]) {
                    $correct++;
                }
            } else {
                if ($question->getCorrect() == $filledQuestions[$i]) {
                    $correct++;
                }
            }
        }

        $percent = $correct / $test->getQuestions()->count() * 100;
        $user = $this->saveResult($email, $difficulty, $test, $percent);

        $last = $this->resultRepository->getLastResults($difficulty);
        $lastValues = [];

        foreach ($last as $l) {
            $lastValues[$l->getDate()->format('d.m. Y H:i')] = $l->getResult() / 100;
        }

        $myLast = $this->resultRepository->getMyLastResults($difficulty, $user->getId());
        $myLastValues = [];

        foreach ($myLast as $l) {
            $myLastValues[$l->getDate()->format('d.m. Y H:i')] = $l->getResult() / 100;
        }

        $this->sendJson([
            'correct' => $correct,
            'percent' => $percent,
            'last' => $lastValues,
            'myLast' => $myLastValues,
        ]);
    }

    private function saveResult($email, $difficulty, Test $test, $correct)
    {
        $user = $this->userRepository->findBy(['email' => $email]);

        if ($user) {
            $user = $user[0];
        }

        if (!$user) {
            $user = new User();
            $user->setEmail($email);
        }

        $this->userRepository->getEntityManager()->persist($user);

        $result = new Result();
        $result->setDate(new \DateTime());
        $result->setDifficulty($difficulty);
        $result->setTest($test);
        $result->setUser($user);
        $result->setResult($correct);

        $this->resultRepository->getEntityManager()->persist($result);
        $this->resultRepository->getEntityManager()->flush($result);

        return $user;
    }
}
