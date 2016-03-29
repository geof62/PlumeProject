<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Exception\models\Exception;
use framework\Utilities\Collection;

/**
 * Class RouteCollection.
 * List of RouteElements
 *
 * @package framework\Router\models
 */
class RouteCollection extends Collection
{
    /**
     * true if a route is matched
     * @var bool
     */
    protected $find = false;

    /**
     * the instance of the FindRoute
     *
     * @var null
     */
    protected $findR = NULL;

    /**
     * RouteCollection constructor.
     * Init the collection.
     *
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        foreach ($routes as $v)
        {
            if (!($v instanceof RouteElement) && !($v instanceof self))
                throw new Exception("element " . $v . " is not a RouteElement");
        }
        parent::__construct($routes);
    }

    /**
     * Add a route in the collection
     *
     * @param RouteElement $route
     * @return RouteCollection
     */
    public function add(RouteElement $route):self
    {
        $this->addNode($route);
        return ($this);
    }

    /**
     * Search if an url matched to any route
     * @param string $url
     * @return RouteCollection
     */
    public function search(string $url):self
    {
        $url = trim($url, "/");
        foreach ($this->data as $v)
        {
            $v->search($url);
            if ($v->isFind())
            {
                $this->find = true;
                $this->findR = $v->getFind();
                break;
            }
        }
        return ($this);
    }

    /**
     * set a FindRoute
     *
     * @param FindRoute $find
     * @return RouteCollection
     */
    public function setFind(FindRoute $find):self
    {
        $this->find = true;
        $this->findR = $find;
        return ($this);
    }

    /**
     * return true if a route matched
     * @return bool
     */
    public function isFind():bool
    {
        return ($this->find);
    }

    /**
     * return the instance of FindRoute
     *
     * @return FindRoute
     */
    public function getFind():FindRoute
    {
        if ($this->isFind())
            return ($this->findR);
        return (NULL);
    }

    public function generate(string $name, array $params):string
    {
        foreach ($this->data as $v)
        {
            if (($url = $v->generate($name, $params)) !== NULL)
                return ($url);
        }
        return (NULL);
    }
}