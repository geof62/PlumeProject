<?php

namespace Framework\Kernel\Application;

use Framework\Kernel\Types\Collection;
use Framework\Kernel\Types\Str;
use Framework\Kernel\Types\Type;

abstract class Request
{
    protected $data;

    final public function __construct(Collection $data = NULL)
    {
        $this->setData($data);
    }

    final public function setData(Collection $data):self
    {
        if ($data === NULL)
            $this->data = new Collection();
        else
            $this->data = $data;
        return ($this);
    }
    
    final public function addData(Str $name, Type $value):self
    {
        $this->data->add($value, $name);
        return ($this);
    }

    final public function getData(Str $name)
    {
        return ($this->data->get($name));
    }
}