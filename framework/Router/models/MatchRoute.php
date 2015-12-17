<?php

declare(strict_types=1);

namespace framework\Router\models;

class MatchRoute
{
    protected $find = false;
    protected $route;
    protected $findParams = [];

    public function __construct()
    {
    }

    public function find():self
    {
        $this->find = true;
        return ($this);
    }

    public function match():bool
    {
        return ($this->find);
    }

    public function setRoute(Route $route):self
    {
        $this->route = $route;
        return ($this);
    }

    public function setParams(array $params):self
    {
        $this->findParams = $params;
        return ($this);
    }

    public function getController()
    {
        return ($this->route->getController());
    }

    public function getAction()
    {
        return ($this->route->getAction());
    }
}