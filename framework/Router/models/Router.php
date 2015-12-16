<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Config\models\Config;
use framework\Exceptions\models\Exception;
use framework\Http\models\Http;
use framework\Http\models\Request;

class Router
{
    protected $dataRoutes;
    protected $url;
    protected $match;
    protected $find = false;
    protected $method;

    public function __construct(Request $request, Config $config)
    {
        $this->setUrl($request->getUri());
        $this->setMethod($request->getMethod());
        $this->setDataRoutes(incAbs($config ->getConfig('Router/fileRoutes')));
    }

    protected function setUrl(string $uri):self
    {
        $this->url = $uri;
        return ($this);
    }

    protected function    setDataRoutes(callable $data):self
    {
        $data = $data();
        if (!($data instanceof RouteCollection))
            throw new Exception("Invalid RouteCollection");
        $this->dataRoutes = $data;
        return ($this);
    }

    protected function setMethod(string $method):self
    {
        $this->method = Http::getMethod($method);
        return ($this);
    }

    public function getRoutes():array
    {
        return ($this->dataRoutes->getAll());
    }

    public function searchRoute()
    {
        $find = $this->dataRoutes->search($this->url, $this->method);
        if ($find->match() == true)
        {
            $this->match = $find;
            $this->find = true;
            return (true);
        }
        return (false);
    }

    public function getMatch():bool
    {
        return ($this->find);
    }

    public function getMatchRoute():MatchRoute
    {
        return ($this->match);
    }
}