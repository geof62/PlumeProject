<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Exception\models\Exception;

/**
 * Class Route
 * @package framework\Router\models
 *
 * Represent a route
 *
 */
class Route extends RouteElement
{
    /**
     * Pattern of the route
     * @var string
     */
    protected $route = "";

    /**
     * list of parameters. form :
     * 'name' => 'regex'
     * @var array
     */
    protected $params = [];

    /**
     * prepared regex
     * @var string
     */
    protected $regex = "";

    /**
     * list of actions by method
     * @var array
     */
    protected $actions = [
        'controller' => NULL,
        'GET' => NULL,
        'POST' => NULL,
        'PUT' => NULL,
        'DEL' => NULL
    ];

    /**
     * name of the route
     * @var string
     */
    protected $name = "";

    /**
     * Parameters in asc order in route pattern
     * @var array
     */
    protected $orderParams = [];

    /**
     * True if a route is matched
     * @var bool
     */
    protected $find = false;

    /**
     * instance of FindRoute if aa route is matched
     * @var FindRoute
     */
    protected $findR;

    /**
     * @description Init the route
     * @param string $route the pattern of the route
     * @param array $params the list of parameters
     */
    public function __construct(string $route, array $params = [])
    {
        $this->setRoute($route)
            ->setParams($params);
    }

    /**
     * set the pattern of the route.
     * Form :
     * ^([a-zA-Z0-9-/]*|(\\{[a-z]*\\}))*$
     * parameter : {parametername}
     * route without / at the begining and the end
     *
     * @param string $route
     * @return Route
     * @throws Exception
     */
    public function setRoute(string $route):self
    {
        if (!preg_match("#^([a-zA-Z0-9-/]*|(\\{[a-z]*\\}))*$#", $route))
            throw new Exception("invalid route");
        $this->route = $route;
        return ($this);
    }

    /**
     * add numerous parameters
     * @param array $params
     * @return Route
     * @throws Exception
     */
    public function setParams(array $params):self
    {
        foreach ($params as $k => $v)
        {
            $this->setParam($k, $v);
        }
        $this->verifParams();
        return ($this);
    }

    /**
     * parameter name : just lowercaser alphacaracters
     * regex : valid regex, without "#", "^" and "$"
     * @param string $name
     * @param string $regex
     * @return Route
     * @throws Exception
     */
    protected function setParam(string $name, string $regex):self
    {
        if (!preg_match("#^[a-z]*$#", $name))
            throw new Exception("Invalid parameter name : " . $name);
        // à cmp vérif de regex
        $this->params[$name] = $regex;
        return ($this);
    }

    /**
     * check if all of the parameters given in the route pattern are present in the parameters array
     * @return Route
     * @throws Exception
     */
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

    /**
     * set the Controller of the Route
     * @param string $controller the controller name, without the end "Controller"
     * @return Route
     * @throws Exception
     */
    public function setController(string $controller):self
    {
        if (!preg_match("#^[a-zA-Z\\\\]*$#", $controller))
            throw new Exception("Invalid controller.");
        $this->actions['controller'] = $controller;
        return ($this);
    }

    /**
     * set the action for get method
     * @param string $action name of the action without the end "Action"
     * @return Route
     * @throws Exception
     */
    public function setGet(string $action):self
    {
        if (!preg_match("#^[a-zA-Z]*$#", $action))
            throw new Exception("Invalid get action");
        $this->actions['GET'] = $action;
        return ($this);
    }

    /**
     * set the action for post method
     * @param string $action name of the action without the end "Action"
     * @return Route
     * @throws Exception
     */
    public function setPost(string $action):self
    {
        if (!preg_match("#^[a-zA-Z]*$#", $action))
            throw new Exception("Invalid post action");
        $this->actions['POST'] = $action;
        return ($this);
    }

    /**
     * set the action for put method
     * @param string $action name of the action without the end "Action"
     * @return Route
     * @throws Exception
     */
    public function setPut(string $action):self
    {
        if (!preg_match("#^[a-zA-Z]*$#", $action))
            throw new Exception("Invalid put action");
        $this->actions['PUT'] = $action;
        return ($this);
    }

    /**
     * set the action for deleted method
     * @param string $action name of the action without the end "Action"
     * @return Route
     * @throws Exception
     */
    public function setDel(string $action):self
    {
        if (!preg_match("#^[a-zA-Z]*$#", $action))
            throw new Exception("Invalid del action");
        $this->actions['DEL'] = $action;
        return ($this);
    }

    /**
     * @param array $actions list of the actions, with the controller
     * @return Route
     * @throws Exception
     */
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


    public function setName(string $name):self
    {
        $this->name = $name;
        return ($this);
    }

    /**
     * get the controller name
     * @return string
     */
    public function getController():string
    {
        return ($this->actions['controller']);
    }

    /**
     * check if the given method is defined
     * @param string $method
     * @return bool
     */
    public function isValidMethod(string $method):bool
    {
        $method = strtoupper($method);
        if (array_key_exists($method, $this->actions) && $method != "CONTROLLER" && $this->actions[$method] !== NULL)
            return (true);
        return (false);
    }

    /**
     * get the action associated with the specific method
     * @param string $method
     * @return string
     * @throws Exception
     */
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

    /**
     * prepare the regex : add regex parameters parts
     * @return Route
     */
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

    /**
     * compare $url and the route pattern
     * @param string $url
     * @return Route
     */
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

    /**
     * return true if the route matched
     * @return bool
     */
    public function isFind():bool
    {
        return ($this->find);
    }

    /**
     * return the instance of FindRoute
     * @return FindRoute
     */
    public function getFind():FindRoute
    {
        if ($this->isFind())
            return ($this->findR);
        return (NULL);
    }

    /**
     * generate a route url by given parameters
     * @param string $name
     * @param array $params
     * @return string
     */
    public function generate(string $name, array $params):string
    {
        if ($this->name === $name)
            return ($this->generateUrl($params));
        return (NULL);
    }

    public function generateUrl(array $params):string
    {
        foreach ($this->params as $k => $v)
        {
            if (!array_key_exists($k, $params))
                return (NULL);
        }
        if (count($params) == 0)
            return ($this->route);
        $url = preg_replace_callback("#(\\{[a-z]*\\})#", function($matches) use ($params) {
            return ($params[$matches[1]]);
        }, $this->route);
        return ($url);
    }
}