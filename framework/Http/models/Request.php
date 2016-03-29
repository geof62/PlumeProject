<?php

declare(strict_types=1);

namespace framework\Http\models;

use framework\Exception\models\Exception;

/**
 * Class Request.
 * Manage the Http Request
 *
 * @package framework\Http\models
 */
class Request
{
    /**
     * list of supported methods
     * @var array
     */
    const HTTP_METHODS = [
        'GET',
        'POST',
        'PUT',
        'DEL'
    ];

    /**
     * safeguard of the $_SERVER
     * @var array
     */
    protected $server;

    /**
     * method of the request
     * @var string
     */
    protected $method;

    /**
     * the uri of the request
     * @var string
     */
    protected $uri;

    /**
     * the time of the request
     * @var float
     */
    protected $beginClientRequest;

    /**
     * true if the request is in TLS
     * @var bool
     */
    protected $tls = false;

    /**
     * IP of the client
     * @var string
     */
    protected $clientIp;

    /**
     * safegard of data get or post
     * @var array
     */
    protected $data = [];

    /**
     * Request constructor.
     * Create a new Request
     *
     * @param array $server generaly $_SERVER, but it can be an created array for simulations
     */
    public function __construct(array $server)
    {
        $this->setServer($server)
            ->hydrate();
    }

    /**
     * hydrate the object by the $server of the constructor
     * @return Request
     * @throws Exception
     */
    public function hydrate():self
    {
        if (!array_key_exists("REQUEST_METHOD", $this->server))
            throw new Exception("No Method precise");
        $this->setMethod($this->server["REQUEST_METHOD"]);

        $this->setData();

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

    /**
     * set the data of request by method : get, post, put, del
     * @return Request
     */
    public function setData():self
    {
        if ($this->method == "GET")
            $this->data = $_GET;
        else if ($this->method == "POST")
            $this->data = $_POST;
        else if ($this->method == "PUT" || $this->method == "DEL")
            parse_str(file_get_contents("php://input"), $this->data);
        return ($this);
    }

    /**
     * @param array $server
     * @return Request
     */
    public function setServer(array $server):self
    {
        $this->server = $server;
        return ($this);
    }

    /**
     * @param string $method
     * @return Request
     * @throws Exception
     */
    public function setMethod(string $method):self
    {
        if (!in_array($method, self::HTTP_METHODS))
            throw new Exception("Invalid Request Method");
        $this->method = strtoupper($method);
        return ($this);
    }

    /**
     * @param string $uri
     * @return Request
     */
    public function setUri(string $uri):self
    {
        $this->uri = $uri;
        return ($this);
    }

    /**
     * @param float $time
     * @return Request
     */
    public function setBeginClientRequest(float $time):self
    {
        $this->beginClientRequest = $time;
        return ($this);
    }

    /**
     * this method passe the propriety $tls at true
     * @return Request
     */
    public function activeHttps():self
    {
        $this->tls = true;
    }

    /**
     * @param string $ip
     * @return Request
     */
    public function setClientIp(string $ip):self
    {
        $this->clientIp = $ip;
        return ($this);
    }

    /**
     * return the safegard of the server config given in the constructor
     * @return array
     */
    public function getServer():array
    {
        return ($this->server);
    }

    /**
     * return the value of the safegard $server by a key, or NULL if the key doesn't exist
     * @param string $key
     * @return string
     */
    public function getServerKey(string $key)
    {
        if (!array_key_exists($key, $this->server))
            return (NULL);
        return ($this->server[$key]);
    }

    /**
     * return the URI of the request
     * @return string
     */
    public function getUri():string
    {
        return ($this->uri);
    }

    /**
     * return the method of the Request
     *
     * @return string
     */
    public function getMethod():string
    {
        return ($this->method);
    }

    /**
     *
     * if $key == NULL (or not precise), send all of data in an array
     *
     * if $key doesn't exist, return NULL
     *
     * @param string|NULL $key
     * @return string
     */
    public function getData(string $key = NULL):string
    {
        if ($key == NULL)
            return $this->data;
        else if (!array_key_exists($key, $this->data))
            return (NULL);
        else
            return ($this->data[$key]);
    }
}