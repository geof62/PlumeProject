<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Config\models\Config;
use framework\Exception\models\Exception;

class Router
{
    protected $routes;
    protected $config;

    public function __construct(callable $collec, Config $conf)
    {
        $this->config = $conf;
        $coll = $collec();
        if (!($coll instanceof RouteCollection))
            throw new Exception("Invalid route collection");
        $this->routes = $coll;
    }

    public function search(string $url)
    {
        $url = trim($url, '/');
        $this->routes->search($url);
        return ($this);
    }

    public function isFind():bool
    {
        return ($this->routes->isFind());
    }

    public function getFind():FindRoute
    {
        return ($this->routes->getFind());
    }

    public function generate(string $name, bool $abs = true, string $lang = ""):string
    {
        // implémenter les noms dans les url
    }
}