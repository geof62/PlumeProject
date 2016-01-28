<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Exception\models\Exception;

class Route extends RouteElement
{
    protected $route = "";
    protected $params = [];
    protected $regex = "";
    protected $actions = [
        'controller' => NULL,
        'GET' => NULL,
        'POST' => NULL,
        'PUT' => NULL,
        'DEL' => NULL
    ];
    protected $orderParams = [];
    protected $find = false;
    protected $findR;

    public function __construct(string $route, array $params = [])
    {
        $this->setRoute($route)
            ->setParams($params);
    }

    public function setRoute(string $route):self
    {
        if (!preg_match("#^([a-zA-Z0-9-/]*|(\\{[a-z]*\\}))*$#", $route))
            throw new Exception("invalid route");
        $this->route = $route;
        return ($this);
    }

    public function setParams(array $params):self
    {
        foreach ($params as $k => $v)
        {
            $this->setParam($k, $v);
        }
        $this->verifParams();
        return ($this);
    }

    protected function setParam(string $name, string $regex):self
    {
        if (!preg_match("#^[a-z]*$#", $name))
            throw new Exception("Invalid parameter name : " . $name);
        // à cmp vérif de regex
        $this->params[$name] = $regex;
        return ($this);
    }

    public function verifParams():self
    {
        preg_match("#\\{([a-z]*)\\}#", $this->route, $matches);
        foreach ($matches as $k => $v)
        {
            if ($k != 0)
            {
                if (!array_key_exists($v, $this->params))
                    throw new Exception("Regex for param " . $v . " is not precise.");
            }
        }
        return ($this);
    }

    public function setController(string $controller):self
    {
        if (!preg_match("#^[a-zA-Z\\\\]*$#", $controller))
            throw new Exception("Invalid controller.");
        $this->actions['controller'] = $controller;
        return ($this);
    }

    public function setGet(string $action):self
    {
        if (!preg_match("#^[a-zA-Z]*$#", $action))
            throw new Exception("Invalid get action");
        $this->actions['GET'] = $action;
        return ($this);
    }

    public function setPost(string $action):self
    {
        if (!preg_match("#^[a-zA-Z]*$#", $action))
            throw new Exception("Invalid post action");
        $this->actions['POST'] = $action;
        return ($this);
    }

    public function setPut(string $action):self
    {
        if (!preg_match("#^[a-zA-Z]*$#", $action))
            throw new Exception("Invalid put action");
        $this->actions['PUT'] = $action;
        return ($this);
    }

    public function setDel(string $action):self
    {
        if (!preg_match("#^[a-zA-Z]*$#", $action))
            throw new Exception("Invalid del action");
        $this->actions['DEL'] = $action;
        return ($this);
    }

    public function setActions(array $actions):self
    {
        foreach($actions as $k => $v)
        {
            if ($k == "controller")
                $this->setController($v);
            else if ($k == "get")
                $this->setGet($v);
            else if ($v == "post")
                $this->setPost($v);
            else if ($v == "put")
                $this->setPut($v);
            else if ($v == "del")
                $this->setDel($v);
        }
        return ($this);
    }

    public function getController():string
    {
        return ($this->actions['controller']);
    }

    public function isValidMethod(string $method):bool
    {
        $method = strtoupper($method);
        if (array_key_exists($method, $this->actions) && $method != "CONTROLLER" && $this->actions[$method] !== NULL)
            return (true);
        return (false);
    }

    public function getActionByMethod(string $method):string
    {
        if (strtolower($method) == "get")
            return ($this->actions['GET']);
        else if (strtolower($method) == "post")
            return ($this->actions['POST']);
        else if (strtolower($method) == "put")
            return ($this->actions['PUT']);
        else if (strtolower($method) == "del")
            return ($this->actions['DEL']);
        else
            throw new Exception("Invalid method : " . $method);
    }

    protected function prepareRegex():self
    {
        $params = $this->params;
        $ord = &$this->orderParams;
        $this->regex = preg_replace_callback("#{([a-z]*)}#", function ($matches) use ($params, &$ord) {
            $ord[] = $matches[1];
            return ('(' . str_replace('(', '(?:', $params[$matches[1]]) . ')');
        }, $this->route);
        return ($this);
    }

    public function search(string $url):self
    {
        $this->prepareRegex();
        if (preg_match("#^" . $this->regex . "$#", $url))
        {
            $this->find = true;
            $this->findR = new FindRoute($this);
            $ord = $this->orderParams;
            $params = [];
            preg_replace_callback("#^" . $this->regex . "$#", function ($matches) use ($ord, &$params) {
                foreach ($matches as $k => $v) {
                    if ($k != 0)
                        $params[$ord[$k - 1]] = $v;
                }
            }, $url);
            $this->findR->addParams($params);
        }
        return ($this);
    }

    public function isFind():bool
    {
        return ($this->find);
    }

    public function getFind():FindRoute
    {
        if ($this->isFind())
            return ($this->findR);
        return (NULL);
    }
}