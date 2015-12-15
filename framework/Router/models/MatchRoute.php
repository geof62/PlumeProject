<?php

declare(strict_types=1);

namespace framework\Router\models;

class MatchRoute
{
    protected $find;
    protected $route;
    protected $findParams = [];

    public function __construct()
    {
        $this->find = false;
    }

    public function find():self
    {
        $this->find = true;
        return ($this);
    }

    public function match():bool
    {

    }
}