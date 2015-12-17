<?php

declare(strict_types=1);

namespace framework\Http\models;

use framework\Config\models\Config;
use framework\Exceptions\models\Exception;
use framework\Router\models\Router;
use framework\Router\models\RouterElement;

class Request extends Http
{
    protected $method = 1;
    protected $uri = "";
    protected $router;
    protected $response;

    /*
     * $_SERVER is specify to permiss to load an other configuration
     */
    public function __construct(array $server, Config $config)
    {
        $this->hydrate($server)
            ->loadRouter($config);
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
        $this->router->searchRoute();
        return ($this);
    }

    protected function loadResponse(Config $config):self
    {
        if ($this->router->find->match() == false)
            new Exception("404 page not found");
        if (!class_exists($this->router->find->getController()))
            new Exception("invalid controller for this url");
        if (!method_exists($this->router->find->getController(), $this->router->find->getAction()))
            new Exception("invalid action for this url");
        $ctrl = $this->router->find->getController();
        $ctrl = $ctrl();
        $this->response = $ctrl->$this->router->find->getAction();
        return ($this);
    }
}