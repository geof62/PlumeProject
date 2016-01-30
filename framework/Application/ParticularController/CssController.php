<?php

declare(strict_types=1);

namespace framework\Application\ParticularController;

use framework\Application\Controller;
use framework\Template\models\CssTemplate;

/**
 * Class CssController.
 * Load css files
 * @package framework\Application\ParticularController
 */
class CssController extends Controller
{
    public function defaultTemplate():string
    {
        return ("framework\\Template\\models\\CssTemplate");
    }

    public function indexAction()
    {
        $this->loadView('web/' . $this->getParam('file') . '.css');
    }
}