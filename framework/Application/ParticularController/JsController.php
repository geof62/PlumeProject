<?php

declare(strict_types=1);

namespace framework\Application\ParticularController;

use framework\Application\Controller;

/**
 * Class JsController.
 * load the js files
 *
 * @package framework\Application\ParticularController
 */
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