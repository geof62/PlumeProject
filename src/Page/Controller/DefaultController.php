<?php

declare(strict_types=1);

namespace src\Page\Controller;

use framework\Application\Controller;

class DefaultController extends Controller
{
    public function defaultTemplate():string
    {
        return ("framework\\Template\\models\\HtmlTemplate");
    }

    public function indexAction()
    {
        $this->loadView('Page:default');
    }

    public function salutAction()
    {
        $this->loadView('Page:default', ['id' => $this->getParam('id')]);
    }
}