<?php

declare(strict_types=1);

namespace framework\Application;

use framework\Http\models\Request;
use framework\Http\models\Response;
use framework\Template\models\Template;

/**
 * Class Controller.
 * Base controller for all controller of the application
 * @package framework\Application
 */
abstract class Controller implements ControllerInterface
{
    /**
     * sauvegarde of Application
     * @var Application
     */
    private $app;

    /**
     * Controller constructor.
     * @param Application $app
     */
    final public function __construct(Application $app)
    {
        $this->app = $app;
        $tmp = $this->defaultTemplate();
        $this->app->setResponse(new Response(new $tmp()));
    }

    /**
     * Load a template and set it in the response
     * @param Template $tmp
     * @return Controller
     */
    public function initResponse(Template $tmp):self
    {
        $this->app->setResponse(new Response($tmp));
        return ($this);
    }

    /**
     * return the request
     * @return Request
     */
    protected function getRequest():Request
    {
        return ($this->app->getRequest());
    }

    /**
     * return an url parameter by is name
     * @param string $param
     * @return string
     */
    protected function getParam(string $param):string
    {
        return ($this->app->getRouter()->getFind()->getParam($param));
    }

    /**
     * generate an url from the router
     * @param $name
     * @param bool $abs
     * @param null $lang
     * @return string
     */
    protected function generateUrl($name, $abs = true, $lang = NULL):string
    {
        return ($this->app->getRouter()->generate($name, $abs, $lang));
    }

    /**
     * load a view in the template
     * @param string $view
     * @param array $params
     */
    protected function loadView(string $view, array $params=[])
    {
        $this->app->getResponse()->getTemplate()->loadView($view, $params);
    }
}