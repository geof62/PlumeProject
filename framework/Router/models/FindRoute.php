<?php

declare(strict_types=1);

namespace framework\Router\models;

/**
 * Class FindRoute
 * @package framework\Router\models
 *
 * this class contains elements got when an url match a route
 *
 */
class FindRoute
{
    /**
     * @var Route
     */
    protected $route;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * FindRoute constructor.
     * @param Route $r
     *
     */
    public function __construct(Route $r)
    {
        $this->setRoute($r);
    }

    /**
     * @param Route $route
     * @return FindRoute
     */
    public function setRoute(Route $route):self
    {
        $this->route = $route;
        return ($this);
    }

    /**
     * @param string $key
     * @param string $value
     * @return FindRoute
     */
    public function addParam(string $key, string $value):self
    {
        $this->params[$key] = $value;
        return ($this);
    }

    /**
     * @param array $params
     * @return FindRoute
     */
    public function addParams(array $params):self
    {
        foreach($params as $k => $v)
        {
            $this->addParam($k, $v);
        }
        return ($this);
    }

    /**
     * @return Route
     *
     * return the instance of Route which is matched
     */
    public function getRoute():Route
    {
        return ($this->route);
    }

    /**
     * @param string $k
     * @return string
     *
     * get an url parameter by is name. Return NULL if the parameter doesn't exist.
     *
     */
    public function getParam(string $k):string
    {
        if (array_key_exists($k, $this->params))
            return ($this->params[$k]);
        return (NULL);
    }
}