<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Config\models\Config;
use framework\Exception\models\Exception;

/**
 * Class Router.
 *
 * @package framework\Router\models
 */
class Router
{
    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Router constructor.
     *
     * @param callable $collec the return of a router's config
     * @param Config $conf
     */
    public function __construct(callable $collec, Config $conf)
    {
        $this->config = $conf;
        $coll = $collec();
        if (!($coll instanceof RouteCollection))
            throw new Exception("Invalid route collection");
        $this->routes = $coll;
    }

    /**
     * search if an url matched to any route
     *
     * @param string $url
     * @return Router
     */
    public function search(string $url)
    {
        $url = trim($url, '/');
        if ($this->filter($url))
            return ($this);
        $this->routes->search($url);
        return ($this);
    }

    /**
     * return true if a route find
     * @return bool
     */
    public function isFind():bool
    {
        return ($this->routes->isFind());
    }

    /**
     * return the instance of FindRoute
     *
     * @return FindRoute
     */
    public function getFind():FindRoute
    {
        return ($this->routes->getFind());
    }

    /**
     * search if the route is style or script route
     * return true is it's
     *
     * @param string $url
     * @return bool
     * @throws Exception
     */
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

    /**
     * return an url generate from the Router
     *
     * @param string $name
     * @param bool $abs
     * @param string $lang
     * @return string
     */
    public function generate(string $name, array $params = [], bool $abs = true, string $lang = ""):string
    {
        $url = "";
        if ($abs === true)
            $url = $this->config->get('site/baseUrl');
        if ($lang != "")
            $url .= $lang . '/';
        if (($url2 = $this->routes->generate($name, $params)) !== NULL)
            return ($url . $url2);
        return (NULL);
    }
}