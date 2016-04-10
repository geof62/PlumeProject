<?php

namespace Framework\Kernel\Types;

class Real extends Type
{
    public function __construct($n = 0)
    {
        $this->set($n);
    }

    public function set($n):self
    {
        if (!is_int($n) && !is_float($n))
            throw new TypeException("no number specified");
        $this->content = $n;
        return ($this);
    }

    public function toInt():self
    {
        $this->content = (int)($this->content);
        return ($this);
    }

    public function toFloat():self
    {
        $this->content = (float)($this->content);
        return ($this);
    }

    public function abs():self
    {
        $this->content = abs($this->content);
        return ($this);
    }

    public function round($size):self
    {
        $size = Type::getOriginal($size);
        $this->content = round($this->content, $size);
        return ($this);
    }
}