<?php

namespace Framework\Kernel\Types;

abstract class Type
    implements TypeInterface
{
    protected $data;

    public function get()
    {
        return ($this->data);
    }

    public function g()
    {
        return ($this->get());
    }

    public function isNull()
    {
        if ($this->data === NULL)
            return (true);
        return (false);
    }
}