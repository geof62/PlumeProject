<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Exceptions\models\Exception;

class Prefix extends RouterElement
{
    protected $route;
    protected $collection;

    public function __construct(string $route, callable $collection)
    {
        $this->setRoute($route)
            ->setCollection($collection);
    }

    public function setRoute(string $route):self
    {
        $route = self::cleanRoute($route);
        if (!preg_match("#^[a-zA-Z/]*$#", $route))
            throw new Exception("invalid routePrefix name");
        $this->route = $route;
        return ($this);
    }

    public function setCollection(callable $collection):self
    {
        $collection = $collection();
        if (!($collection instanceof RouteCollection))
            throw new Exception("Invalid RouteCollection");
        $this->collection = $collection;
        return ($this);
    }

    public function getRoute():string
    {
        return ($this->route);
    }

    public function getCollection():RouteCollection
    {
        return ($this->collection);
    }
}