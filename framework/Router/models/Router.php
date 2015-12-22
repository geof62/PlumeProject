<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Config\models\Config;
use framework\Exceptions\models\Exception;
use framework\Http\models\Http;
use framework\Http\models\Request;

class Router
{
    protected $dataRoutes;
    protected $url;
    protected $match;
    protected $find = false;
    protected $method;
    protected $css = false;
    protected $js = false;

    public function __construct(Request $request, Config $config)
    {
        $this->setUrl($request->getUri());
        $this->setMethod($request->getMethodR());
        $this->setDataRoutes(incAbs($config ->getConfig('Router/fileRoutes')));
    }

    protected function setUrl(string $uri):self
    {
        $this->url = $uri;
        return ($this);
    }

    protected function    setDataRoutes(callable $data):self
    {
        $data = $data();
        if (!($data instanceof RouteCollection))
            throw new Exception("Invalid RouteCollection");
        $this->dataRoutes = $data;
        return ($this);
    }

    protected function setMethod(int $method):self
    {
        $this->method = $method;
        return ($this);
    }

    public function getRoutes():array
    {
        return ($this->dataRoutes->getAll());
    }

    public function searchRoute(Config $config)
    {
        if ($this->filter($config) == false)
        {
            $find = $this->dataRoutes->search($this->url, $this->method);
            if ($find->match() == true) {
                $this->match = $find;
                $this->find = true;
                return (true);
            }
            return (false);
        }
        return (true);
    }

    public function filter(Config $config):bool
    {
        if (preg_match("#^" . $config->getConfig('Router/scriptsPrefix') . "#", $this->url))
            $this->loadJs(str_replace($config->getConfig('Router/scriptsPrefix'), '', $this->url));
        else if (preg_match("#^" . $config->getConfig('Router/stylesPrefix') . "#", $this->url))
            $this->loadCss(str_replace($config->getConfig('Router/stylesPrefix'), '', $this->url));
        else
            return (false);
        return (true);
    }

    public function loadJs(string $js)
    {
        $this->js = $js;
    }

    public function loadCss(string $css)
    {
        $this->css = $css;

    }

    public function isJs():bool
    {
        if ($this->js === false)
            return (false);
        return (true);
    }

    public function getJs():string
    {
        return ($this->js);
    }

    public function isCss():bool
    {
        if ($this->css === false)
            return (false);
        return (true);
    }

    public function getCss():string
    {
        return ($this->css);
    }

    public function getMatch():bool
    {
        return ($this->find);
    }

    public function getMatchRoute():MatchRoute
    {
        return ($this->match);
    }
}