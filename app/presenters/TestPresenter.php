<?php

namespace App\Presenters;

use App\Entities\Test;
use App\Entities\User;
use App\Repositories\TestRepository;
use App\Forms\TestFormFactory;
use Nette;
use Nette\Http\IResponse;


class TestPresenter extends BasePresenter
{
    /** @var TestFormFactory @inject */
    public $testFormFactory;

    /** @var TestRepository @inject */
    public $testRepository;

    /** @var  Test|NULL */
    private $editingTest;

    public function startup()
    {
        parent::startup();

        if ( ! $this->user->isLoggedIn() && !$this->user->isInRole(User::ADMIN)) {
            $this->error('Nemáte oprávnění', IResponse::S403_FORBIDDEN);
        }
    }

    public function renderCreate()
    {
        $this['testForm']['id']->setDisabled();
    }

    public function renderDetail($id)
    {
        $this->template->test = $this->testRepository->find($id);
    }

    public function renderDefault()
    {
        $this->template->tests = $this->testRepository->findAll();
    }

    public function actionEdit($id)
    {
        $this->editingTest = $this->testRepository->find($id);

        if ( ! $this->editingTest) {
            $this->error('Neexistující test');
        }
    }

    public function actionDelete($id)
    {
        $test = $this->testRepository->find($id);

        if ($test) {
            $this->testRepository->getEntityManager()->remove($test);
            $this->testRepository->getEntityManager()->flush();
            $this->flashMessage('Test '. $test->getName() . ' byl úspěšně odstraněn');
        }

        $this->redirect('Test:');
    }

    /**
     * Edit form factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentTestForm()
    {
        $form = $this->testFormFactory->create($this->editingTest);

        $form->onSuccess[] = function (Nette\Application\UI\Form $form, $values){
            $test = $this->testRepository->saveFormData($values);
            $this->redirect('Test:detail', $test->getId());
        };

        return $form;
    }
}
