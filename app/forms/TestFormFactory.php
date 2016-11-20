<?php

namespace App\Forms;

use App\Entities\Test;
use Nette;
use Nette\Application\UI\Form;


class TestFormFactory extends Nette\Application\UI\Control
{
    use Nette\SmartObject;

    /**
     * @param Test|NULL $test
     * @return Form
     */
    public function create(Test $test = NULL)
    {
        $form = new Form;

        $form->addHidden('id');

        $form->addText('name', 'Název')
            ->addRule(Form::FILLED, "`%label` je povinný.");

        $form->addSubmit('send');

        if ($test) {
            $this->setDefaults($test, $form);
        }

        return $form;
    }

    /**
     * @param Test $test
     * @param $form
     */
    private function setDefaults(Test $test, $form)
    {
        $form['id']->setDefaultValue($test->getId());
        $form['name']->setDefaultValue($test->getName());
    }
}
