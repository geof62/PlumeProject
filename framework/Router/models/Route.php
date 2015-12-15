<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Exceptions\models\Exception;
use framework\Http\models\Http;

class Route extends RouterElement
{
    protected $route = "";
    protected $params = [];
    protected $methods = [];
    protected $action = [];

    public function __construct(string $route, $params, $action, $methods = [])
    {
        if (count($methods) == 0)
            $methods = [Http::$methods['ALL']];
        $this->setRoute($route)
            ->setParams($params)
            ->setAction($action)
            ->setMethods($methods);
    }

    public function setRoute(string $route):self
    {
        $route = self::cleanRoute($route);
        if (!preg_match("#^((([a-zA-Z0-9-.\\/]+)|({[a-zA-Z]+}))+)$#", $route))
            throw new Exception("Invalid route");
        preg_match("#{[a-zA-Z]*}#", $route, $matches);
        foreach ($matches as $v)
        {
            $first = 0;
            foreach ($matches as $v2)
            {
                if ($v == $v2)
                    $first++;
                if ($first == 2)
                    throw new Exception("Paramters'names must be unique");
            }
        }
        $this->route = $route;
        return ($this);
    }

    public function setParams(array $params):self
    {
        foreach ($params as $k => $v)
        {
            if (!preg_match("#[a-zA-Z]+#", $k) || !preg_match("#$v#", null))
                throw new Exception("Invalid paramter : " . $k);
        }
        $this->validParams($params);
        $this->params = $params;
        return ($this);
    }

    public function validParams(array $params):self
    {
        preg_match("#{[a-zA-Z]+}#", $this->route, $mat);
        foreach ($mat as $v)
        {
            if (!in_array($v, $params))
                throw new Exception("Parameter inexistant " . $v);
        }
        return ($this);
    }

    public function setAction(array $action):self
    {
        foreach ($action as $k => $v)
        {
            if ($k != 'ctrl' && $k != 'action')
                throw new Exception("Invalid actions : you must specify a controller and an action");
            if (!preg_match("#[a-zA-Z]*#", $v))
                throw new Exception("Invalid " . $k . " value : " . $v);
        }
        $this->action = $action;
        return ($this);
    }

    public function setMethods(array $methods):self
    {
        foreach ($methods as $v)
        {
            if (!Http::isMethod($v))
            {
                throw new Exception("invalid Method : " . $v);
            }
        }
        $this->methods = $methods;
        return ($this);
    }
}