<?php

declare(strict_types=1);

namespace framework\Router\models;

class FindRoute
{
    protected $route;
    protected $params = [];

    public function __construct(Route $r)
    {
        $this->setRoute($r);
    }

    public function setRoute(Route $route):self
    {
        $this->route = $route;
        return ($this);
    }

    public function addParam(string $key, string $value):self
    {
        $this->params[$key] = $value;
        return ($this);
    }

    public function addParams(array $params):self
    {
        foreach($params as $k => $v)
        {
            $this->addParam($k, $v);
        }
        return ($this);
    }

    public function getRoute():Route
    {
        return ($this->route);
    }

    public function getParam(string $k):string
    {
        if (array_key_exists($k, $this->params))
            return ($this->params[$k]);
        return (NULL);
    }
}