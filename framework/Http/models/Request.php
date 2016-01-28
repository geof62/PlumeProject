<?php

declare(strict_types=1);

namespace framework\Http\models;

use framework\Exception\models\Exception;

class Request
{
    const HTTP_METHODS = [
        'GET',
        'POST',
        'PUT',
        'DEL'
    ];
    protected $server;
    protected $method;
    protected $uri;
    protected $beginClientRequest;
    protected $tls = false;
    protected $clientIp;

    public function __construct(array $server)
    {
        $this->setServer($server)
            ->hydrate();
    }

    public function hydrate():self
    {
        if (!array_key_exists("REQUEST_METHOD", $this->server))
            throw new Exception("No Method precise");
        $this->setMethod($this->server["REQUEST_METHOD"]);

        if (!array_key_exists("url", $_GET))
            throw new Exception("No Uri precise");
        $this->setUri($_GET['url']);

        if (!array_key_exists("REQUEST_TIME_FLOAT", $this->server))
            throw new Exception("No begin request time precise");
        $this->setBeginClientRequest($this->server["REQUEST_TIME_FLOAT"]);

        if (array_key_exists("HTTPS", $this->server) && $this->server == 1)
            $this->activeHttps();

        if (!array_key_exists("REMOTE_ADDR", $this->server))
            throw new Exception("No client ip precise");
        $this->setClientIp($this->server["REMOTE_ADDR"]);
        return ($this);
    }

    public function setServer(array $server):self
    {
        $this->server = $server;
        return ($this);
    }

    public function setMethod(string $method):self
    {
        if (!in_array($method, self::HTTP_METHODS))
            throw new Exception("Invalid Request Method");
        $this->method = $method;
        return ($this);
    }

    public function setUri(string $uri):self
    {
        $this->uri = $uri;
        return ($this);
    }

    public function setBeginClientRequest(float $time):self
    {
        $this->beginClientRequest = $time;
        return ($this);
    }

    public function activeHttps():self
    {
        $this->tls = true;
    }

    public function setClientIp(string $ip):self
    {
        $this->clientIp = $ip;
        return ($this);
    }

    public function getServer():array
    {
        return ($this->server);
    }

    public function getServerKey(string $key)
    {
        if (!array_key_exists($key, $this->server))
            return (NULL);
        return ($this->server[$key]);
    }

    public function getUri():string
    {
        return ($this->uri);
    }

    public function getMethod():string
    {
        return ($this->method);
    }
}