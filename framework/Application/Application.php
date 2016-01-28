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

class Application
{
    protected $config;
    protected $request;
    protected $router;
    protected $ctrl;
    protected $response;

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

    public function filterApi():bool
    {
        $url = trim($this->request->getUri(), '/');
        if ($url == "")
            return (false);
        if (substr($url, 0, strlen($this->config->get('Api/prefix'))) === $this->config->get('Api/prefix'))
            return (true);
        return (false);
    }

    public function loadFrontPage():self
    {
        incAbs('web/' . $this->config->get('Api/front'));
        return ($this);
    }

    /*
     * Le découpage en plusieurs méthodes (ci-dessous) de l'application permettra d'implémenter un Event listener
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

    public function setResponse(Response $res):self
    {
        $this->response = $res;
        return ($this);
    }

    public function sendResponse():self
    {
        $this->response->send();
        return ($this);
    }

    public function getConfig():Config
    {
        return ($this->config);
    }

    public function getRequest():Request
    {
        return ($this->request);
    }

    public function getRouter():Router
    {
        return ($this->router);
    }

    public function getResponse():Response
    {
        return ($this->response);
    }

    public function error(int $code, string $msg = NULL):self
    {
        throw new Exception("error : " . $code . " message : " . $msg);
    }
}