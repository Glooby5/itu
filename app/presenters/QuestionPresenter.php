<?php

namespace App\Presenters;

use App\Entities\Question;
use App\Entities\Test;
use App\Entities\User;
use App\Repositories\QuestionRepository;
use App\Forms\QuestionFormFactory;
use App\Repositories\TestRepository;
use Nette;
use Nette\Http\IResponse;


class QuestionPresenter extends BasePresenter
{
    /** @var QuestionFormFactory @inject */
    public $questionFormFactory;

    /** @var QuestionRepository @inject */
    public $questionRepository;

    /** @var TestRepository @inject */
    public $testRepository;

    /** @var  Question|NULL */
    private $editingQuestion;

    /** @var  Test */
    private $test;

    public function startup()
    {
        parent::startup();

        if ( ! $this->user->isLoggedIn() && !$this->user->isInRole(User::ADMIN)) {
            $this->error('Nemáte oprávnění', IResponse::S403_FORBIDDEN);
        }
    }

    public function renderCreate($id)
    {
        $this->test = $this->testRepository->find($id);

        if ( ! $this->test) {
            $this->error('Neexistující question');
        }
    }

    public function renderDetail($id)
    {
        $this->template->question = $this->questionRepository->find($id);
    }

    public function actionEdit($id)
    {
        $this->editingQuestion = $this->questionRepository->find($id);

        if ( ! $this->editingQuestion) {
            $this->error('Neexistující question');
        }
    }

    public function actionDelete($id)
    {
        $question = $this->questionRepository->find($id);

        if ($question) {
            $this->questionRepository->getEntityManager()->remove($question);
            $this->questionRepository->getEntityManager()->flush();
            $this->flashMessage('Otázka '. $question->getName() . ' byla úspěšně odstraněna');
        }

        $this->redirect('Question:');
    }

    /**
     * Edit form factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentQuestionForm()
    {
        $form = $this->questionFormFactory->create($this->editingQuestion, $this->test);

        $form->onSuccess[] = function (Nette\Application\UI\Form $form, $values){
            $question = $this->questionRepository->saveFormData($values);
            $this->redirect('Question:detail', $question->getId());
        };

        return $form;
    }
}
