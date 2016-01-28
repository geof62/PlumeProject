<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Exception\models\Exception;
use framework\Utilities\Collection;

class RouteCollection extends Collection
{
    protected $find = false;
    protected $findR = NULL;

    public function __construct(array $routes)
    {
        foreach ($routes as $v)
        {
            if (!($v instanceof RouteElement) && !($v instanceof self))
                throw new Exception("element " . $v . " is not a RouteElement");
        }
        parent::__construct($routes);
    }

    public function add(RouteElement $route):self
    {
        $this->addNode($route);
        return ($this);
    }

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

    public function setFind(FindRoute $find):self
    {
        $this->find = true;
        $this->findR = $find;
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