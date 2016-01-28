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
        if ($this->filter($url))
            return ($this);
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

    public function filter(string $url):bool
    {
        if (substr($url, 0, strlen($this->config->get('Router/stylesPrefix'))) == $this->config->get('Router/stylesPrefix'))
        {
            $css = new Route('css');
            $css->setController($this->config->get('Router/cssController'));
            $css->setGet('index');
            $this->routes->setFind((new FindRoute($css))->addParam('file', substr($url, strlen($this->config->get('Router/stylesPrefix')))));
            return (true);
        }
        else  if (substr($url, 0, strlen($this->config->get('Router/scriptsPrefix'))) == $this->config->get('Router/scriptsPrefix'))
        {
            $css = new Route('js');
            $css->setController($this->config->get('Router/jsController'));
            $css->setGet('index');
            $this->routes->setFind((new FindRoute($css))->addParam('file', substr($url, strlen($this->config->get('Router/scriptsPrefix')))));
            return (true);
        }
        return (false);
    }

    public function generate(string $name, bool $abs = true, string $lang = ""):string
    {
        // implémenter les noms dans les url
    }
}