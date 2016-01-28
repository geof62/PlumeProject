<?php

declare(strict_types=1);

namespace framework\Application\ParticularController;

use framework\Application\Controller;

class JsController extends Controller
{
    public function defaultTemplate():string
    {
        return ("framework\\Template\\models\\JsTemplate");
    }

    public function indexAction()
    {
        $this->loadView('web/js' . $this->getParam('file') . '.js');
    }
}