<?php

declare(strict_types=1);

namespace framework\Http\models;

use framework\Config\models\Config;
use framework\Exceptions\models\Exception;
use framework\Router\models\Router;
use framework\Router\models\RouterElement;
use framework\Template\models\CssTemplate;
use framework\Template\models\JsonTemplate;
use framework\Template\models\JsTemplate;

class Request extends Http
{
    protected $method = 1;
    protected $uri = "";
    protected $router;
    protected $response;
    protected $config;

    /*
     * $_SERVER is specify to permiss to load an other configuration
     */
    public function __construct(array $server, Config $config)
    {
        $this->config = $config;
        $this->hydrate($server)
            ->loadRouter($config)
            ->loadResponse()
            ->put();
    }

    public function hydrate(array $server):self
    {
        $this->setUri($server)
            ->setMethod($server);
        return ($this);
    }

    public function setUri(array $server):self
    {
        if (!array_key_exists('REQUEST_URI', $server))
            throw new Exception("URI isn't precise");
        $this->uri = RouterElement::cleanRoute($server['REQUEST_URI']);
        return ($this);
    }

    public function setMethod(array $server):self
    {
        if (array_key_exists('REQUEST_METHOD', $server))
            $this->method = Http::getMethod($server['REQUEST_METHOD']);
        return ($this);
    }

    public function getMethodR():int
    {
        return ($this->method);
    }

    public function getUri():string
    {
        return $this->uri;
    }

    protected function loadRouter(Config $config):self
    {
        $this->router = new Router($this, $config);
        $this->router->searchRoute($config);
        return ($this);
    }

    protected function loadResponse():self
    {
        if ($this->router->isCss()) {
            $this->response = new Response('css');
            $this->response->setTemp((new CssTemplate($this->router->getCss())));
            return ($this);
        }
        else
        {
            $this->response = new Response('js');
            $this->response->setTemp((new JsTemplate($this->router->getJs())));
            return ($this);
        }
        if ($this->router->getMatch() == false)
            throw new Exception("404 page not found");
        $_ctrl = explode(':', $this->router->getMatchRoute()->getController());
        if (count($_ctrl) == 2)
            $ctrl = 'src\\' . $_ctrl[0] . '\\Controller\\' . $_ctrl[1] . 'Controller';
        else
            $ctrl = 'src\\General\\Controller\\' . $_ctrl[0] . 'Controller';
        if (!class_exists($ctrl))
            throw new Exception("invalid controller for this url");
        if (!method_exists($ctrl, $this->router->getMatchRoute()->getAction()))
            throw new Exception("invalid action for this url");
        $ctrl = new $ctrl($this->config);
        $act = $this->router->getMatchRoute()->getAction();
        $this->response = $ctrl->$act();
        return ($this);
    }

    protected function put():self
    {
        $this->response->put();
        return ($this);
    }
}