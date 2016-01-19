<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Exception\models\Exception;

class Prefix extends RouteElement
{
    protected $prefix;
    protected $data;

    public function __construct(string $prefix, RouteCollection $collection)
    {
        $this->setPrefix($prefix)
            ->setData($collection);
    }

    public function setPrefix(string $prefix):self
    {
        if (!preg_match("#^[a-zA-Z-]*$#", $prefix))
            throw new Exception("Invalid prefix name");
        $this->prefix = $prefix;
        return ($this);
    }

    public function setData(RouteCollection $collection):self
    {
        $this->data = $collection;
        return ($this);
    }

    public function search(string $url):self
    {
        $url = trim($url, "/");
        if (!substr($url, 0, strlen($this->prefix)) === $this->prefix)
            return ($this);
        $url = substr($url, strlen($this->prefix));
        $this->data->search($url);
        return ($this);
    }

    public function isFind():bool
    {
        return ($this->data->isFind());
    }

    public function getFind():FindRoute
    {
        return ($this->data->getFind());
    }
}