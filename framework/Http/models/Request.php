<?php

declare(strict_types=1);

namespace framework\Http\models;

use framework\Router\models\RouterElement;

class Request extends Http
{
    protected $method = 1;
    protected $uri = "";

    /*
     * $_SERVER is specify to permiss to load an other configuration
     */
    public function __construct(array $server)
    {
        $this->uri = RouterElement::cleanRoute($server['REQUEST_URI']);
        $this->method = Http::getMethod($server['REQUEST_METHOD']);
    }

    public function getMethodR():int
    {
        return ($this->method);
    }

    public function getUri():string
    {
        return $this->uri;
    }


}