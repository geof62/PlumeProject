<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Exception\models\Exception;

/**
 * Class Prefix
 * @package framework\Router\models
 *
 * this class is like a RouteCollection, but it precise a prefix in url.
 *
 */
class Prefix extends RouteElement
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var RouteCollection
     */
    protected $data;

    /**
     * Prefix constructor.
     * @param string $prefix name of the prefix
     * @param RouteCollection $collection
     *
     * Init the Prefix
     *
     */
    public function __construct(string $prefix, RouteCollection $collection)
    {
        $this->setPrefix($prefix)
            ->setData($collection);
    }

    /**
     * @param string $prefix
     * @return Prefix
     * @throws Exception
     *
     * Add the prefix
     *
     */
    public function setPrefix(string $prefix):self
    {
        if (!preg_match("#^[a-zA-Z-]*$#", $prefix))
            throw new Exception("Invalid prefix name");
        $this->prefix = $prefix;
        return ($this);
    }

    /**
     * @param RouteCollection $collection
     * @return Prefix
     *
     * add the RouteCollection
     *
     */
    public function setData(RouteCollection $collection):self
    {
        $this->data = $collection;
        return ($this);
    }

    /**
     * @param string $url
     * @return Prefix
     *
     * Search if a url correspond to any route
     *
     */
    public function search(string $url):self
    {
        $url = trim($url, "/");
        if (!substr($url, 0, strlen($this->prefix)) === $this->prefix)
            return ($this);
        $url = substr($url, strlen($this->prefix));
        $this->data->search($url);
        return ($this);
    }

    /**
     * @return bool
     *
     * return true if search() found a correspondance
     *
     */
    public function isFind():bool
    {
        return ($this->data->isFind());
    }

    /**
     * @return FindRoute
     *
     *  return the instance of findroute
     *
     */
    public function getFind():FindRoute
    {
        return ($this->data->getFind());
    }

    /**
     * search if it contain a route $name and return url by given parameters
     * @param string $name
     * @param array $params
     * @return string
     */
    public function generate(string $name, array $params):string
    {
        if (($url = $this->data->generate($name, $params)) !== NULL)
            return ($this->prefix . '/' . $url);
    }
}