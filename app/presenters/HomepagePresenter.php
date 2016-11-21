<?php

namespace App\Presenters;

use App\Repositories\TestRepository;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var TestRepository
     * @inject
     */
    public $testRepository;

    public function renderDefault()
    {
        $this->template->test = $this->testRepository->findAll()[0];
    }
}
