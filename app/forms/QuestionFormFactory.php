<?php

namespace App\Forms;

use App\Entities\Question;
use App\Entities\Test;
use Nette;
use Nette\Application\UI\Form;


class QuestionFormFactory extends Nette\Application\UI\Control
{
    use Nette\SmartObject;

    /**
     * @param Question|NULL $question
     * @param Test $test
     * @return Form
     */
    public function create(Question $question = NULL, Test $test = NULL)
    {
        $form = new Form;

        $form->addHidden('id');
        $form->addHidden('test');

        $form->addText('question', 'Otázka')
            ->addRule(Form::FILLED, "`%label` je povinná.");

        $form->addText('answer1', 'Odpověď')
            ->addRule(Form::FILLED, "`%label` je povinná.");
        $form->addText('answer2', 'Odpověď')
            ->addRule(Form::FILLED, "`%label` je povinná.");
        $form->addText('answer3', 'Odpověď')
            ->addRule(Form::FILLED, "`%label` je povinná.");

        $form->addSelect('correct', 'Správná odpověď', [
            Question::FIRST_ANSWER => 'První',
            Question::SECOND_ANSWER => 'Druhá',
            Question::THIRD_ANSWER => 'Třetí'
        ]);

        $form->addText('fulltextAnswer', 'Fulltextové odpověď')
            ->addRule(Form::FILLED, "`%label` je povinná.");

        $form->addSubmit('send');

        if ($question) {
            $this->setDefaults($question, $form);
        }

        if ($test) {
            $form['test']->setDefaultValue($test->getId());
        }

        return $form;
    }

    /**
     * @param Question $question
     * @param $form
     */
    private function setDefaults(Question $question, $form)
    {
        $form['id']->setDefaultValue($question->getId());
        $form['test']->setDefaultValue($question->getTest());
        $form['question']->setDefaultValue($question->getQuestion());
        $form['answer1']->setDefaultValue($question->getFirst());
        $form['answer2']->setDefaultValue($question->getSecond());
        $form['answer3']->setDefaultValue($question->getThird());
        $form['correct']->setDefaultValue($question->getCorrect());
        $form['fulltextAnswer']->setDefaultValue($question->getFulltextAnswer());
    }
}
