<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Exceptions\models\Exception;
use framework\Utilities\Collection;

class RouteCollection extends Collection
{
    public function __construct(callable $data=null)
    {
        if ($data != null) {
            $data = $data();
            $this->setRoutes($data);
        }
    }

    public function setRoutes(array $data):self
    {
        foreach ($data as $v)
        {
            if (!($v instanceof RouterElement))
                throw new Exception("invalid route element in the collection");
            $this->addNode($v);
        }
        return ($this);
    }

    public function search(string $url, $method, $prefix = ''):MatchRoute
    {
        foreach ($this->data as $v)
        {
            if (!empty($find))
                unset($find);
            if ($v instanceof Route)
            {
                $find = $v->prepareRegex()->compare($url, $prefix, $method);
            }
            else
                $find = $v->search($url, $prefix);
            if ($find->match() == true)
                break;
        }
        return ($find);
    }
}