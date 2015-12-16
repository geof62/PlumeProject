<?php

declare(strict_types=1);

namespace framework\Http\models;

class Request extends Http
{
    protected $method = 1;
    protected $uri = "";

    /*
     * $_SERVER is specify to permiss to load an other configuration
     */
    public function __construct(array $server)
    {
        $this->uri = $server['REQUEST_URI'];
    }

    public function getMethods():int
    {
        return ($this->method);
    }

    public function getUri():string
    {
        return $this->uri;
    }


}