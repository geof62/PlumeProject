<?php

declare(strict_types=1);

namespace framework\Application;

use framework\Http\models\Request;
use framework\Http\models\Response;
use framework\Template\models\Template;

abstract class Controller implements ControllerInterface
{
    private $app;

    final public function __construct(Application $app)
    {
        $this->app = $app;
        $tmp = $this->defaultTemplate();
        $this->app->setResponse(new Response(new $tmp()));
    }

    public function initResponse(Template $tmp):self
    {
        $this->app->setResponse(new Response($tmp));
        return ($this);
    }

    protected function getRequest():Request
    {
        return ($this->app->getRequest());
    }

    protected function getParam(string $param):string
    {
        return ($this->app->getRouter()->getFind()->getParam($param));
    }

    protected function generateUrl($name, $abs = true, $lang = NULL):string
    {
        return ($this->app->getRouter()->generate($name, $abs, $lang));
    }

    protected function loadView(string $view, array $params=[])
    {
        $this->app->getResponse()->getTemplate()->loadView($view, $params);
    }
}