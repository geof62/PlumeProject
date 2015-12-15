<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Config\models\Config;
use framework\Exceptions\models\Exception;
use framework\Http\models\Request;

class Router
{
    protected $dataRoutes;
    protected $url;

    public function __construct(Request $request, Config $config)
    {
        $this->setUrl($request->getUri());
        $this->setDataRoutes(incAbs($config ->getConfig('Router/fileRoutes')));
    }

    protected function setUrl(string $uri):self
    {
        $this->url = $uri;
        return ($this);
    }

    protected function setDataRoutes(callable $data):self
    {
        $data = $data();
        if (!($data instanceof RouteCollection))
            throw new Exception("Invalid RouteCollection");
        $this->dataRoutes = $data;
        return ($this);
    }
}