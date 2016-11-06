<?php

namespace App\Presenters;

use Nette;
use App\Forms;


class SignPresenter extends BasePresenter
{
    /** @var Forms\SignInFormFactory @inject */
    public $signInFactory;
    /**
     * Sign-in form factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm()
    {
        $form = $this->signInFactory->create();

        $form->onSuccess[] = function () {
            $this->redirect('Homepage:');
        };

        return $form;
    }

    public function actionOut()
    {
        $this->getUser()->logout();
    }
}
