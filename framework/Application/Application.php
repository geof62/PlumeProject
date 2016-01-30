<?php

declare(strict_types=1);

namespace framework\Application;

use framework\Config\models\Config;
use framework\Exception\models\Exception;
use framework\Http\models\Request;
use framework\Http\models\Response;
use framework\Models\models\BaseEntity;
use framework\Models\models\Entity;
use framework\Router\models\Router;
use framework\Router\models\RouterLanguage;
use framework\Template\models\Template;

/**
 * Class Application.
 * Base of the framework, this class allow to lance the Application, width all of component
 *
 * @package framework\Application
 */
class Application
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Controller
     */
    protected $ctrl;

    /**
     * @var Response
     */
    protected $response;

    /**
     *  Init the application, load Config, Request and Router
     *
     * Application constructor.
     * @param string $baseConfig location of the config
     */
    public function __construct(string $baseConfig)
    {
        $this->config = new Config(incAbs($baseConfig . 'config/config.php'));
        $this->request = new Request($_SERVER);
        if ($this->filterApi())
        {
            $this->request->setUri(substr($this->request->getUri(), strlen($this->config->get('Api/prefix'))));
            if ($this->config->get('Translation/enable') === true)
                $this->router = new RouterLanguage(incAbs($baseConfig . 'router/routes.php'), incAbs($baseConfig . $this->config->get('Translation/file')), $this->config);
            else
                $this->router = new Router(incAbs($baseConfig . 'router/routes.php'), $this->config);
            $this->start()
                ->exec()
                ->sendResponse();
        }
        else
            $this->loadFrontPage();
    }

    /**
     *  Check if the url correspond to an api url
     *
     * @return bool
     */
    public function filterApi():bool
    {
        $url = trim($this->request->getUri(), '/');
        if ($url == "")
            return (false);
        if (substr($url, 0, strlen($this->config->get('Api/prefix'))) === $this->config->get('Api/prefix'))
            return (true);
        return (false);
    }

    /**
     * If the url isn't an api url, return the front base
     *
     * @return Application
     */
    public function loadFrontPage():self
    {
        incAbs('web/' . $this->config->get('Api/front'));
        return ($this);
    }

    /*
     * Le découpage en plusieurs méthodes (ci-dessous) de l'application permettra d'implémenter un Event listener
     */

    /**
     * load the controller of the Application
     *
     * @return Application
     * @throws Exception
     */
    public function start():self
    {
        $this->router->search($this->request->getUri());
        if ($this->router->isFind() === true && $this->router->getFind()->getRoute()->isValidMethod($this->request->getMethod()))
        {
            $ctrl = $this->router->getFind()->getRoute()->getController();
            $ctrl .= 'Controller';
            if (!class_exists($ctrl))
                $this->error(500, "The controller '" . $ctrl . "' was not find'");
            else
            {
                $this->ctrl = new $ctrl($this);
                if (!($this->ctrl instanceof Controller))
                    $this->error(500, "Invalid Controller : it must extend Controller()");
                Entity::setApp($this);
            }
        }
        else
            $this->error(404);
        return ($this);
    }

    /**
     * Load the method of the controller, and execute the application
     *
     * @return Application
     * @throws Exception
     */
    public function exec():self
    {
        $action = $this->router->getFind()->getRoute()->getActionByMethod($this->request->getMethod());
        $action .= 'Action';
        if (!method_exists($this->ctrl, $action))
            $this->error(500, "Action '" . $action . "' was not found'");
        else
        {
            $this->ctrl->$action();
        }
        return ($this);
    }

    /**
     * add the Response for the Application
     *
     * @param Response $res
     * @return Application
     */
    public function setResponse(Response $res):self
    {
        $this->response = $res;
        return ($this);
    }

    /**
     * send the Response to the client
     *
     * @return Application
     */
    public function sendResponse():self
    {
        $this->response->send();
        return ($this);
    }

    /**
     * get the config
     *
     * @return Config
     */
    public function getConfig():Config
    {
        return ($this->config);
    }

    /**
     *  get the current Request
     *
     * @return Request
     */
    public function getRequest():Request
    {
        return ($this->request);
    }

    /**
     * get the current Router
     *
     * @return Router
     */
    public function getRouter():Router
    {
        return ($this->router);
    }

    /**
     * get the current Response
     *
     * @return Response
     */
    public function getResponse():Response
    {
        return ($this->response);
    }

    /**
     * generate an error
     *
     * @param int $code
     * @param string|NULL $msg
     * @return Application
     * @throws Exception     *
     */
    public function error(int $code, string $msg = NULL):self
    {
        throw new Exception("error : " . $code . " message : " . $msg);
    }
}