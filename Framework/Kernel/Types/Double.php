<?php

namespace Framework\Kernel\Types;

class Double
    extends Type
{
    public function __construct($value = NULL)
    {
        $this->set($value);
    }

    public function set($value):self
    {
        if ($value === NULL)
            $this->data = NULL;
        else if (is_float($value))
            $this->data = $value;
        else if (is_int($value))
            $this->data = $value * 1.00;
        else if ($value instanceof Double)
            $this->data = $value->get();
        else
            throw new TypeException("invalid value given");
        return ($this);
    }

    public function dup():self
    {
        return (new self($this));
    }

    public function add(Double $nb):self
    {
        $this->data += $nb->get();
        return ($this);
    }

    public function sub(Double $nb):self
    {
        $this->data -= $nb->get();
        return ($this);
    }

    public function div(Double $nb):self
    {
        if ($nb->get() == 0)
            throw new TypeException("Division By Zero");
        $this->data /= $nb->get();
    }

    public function mult(Double $nb):self
    {
        $this->data *= $nb->get();
        return ($this);
    }

    public function abs():self
    {
        if ($this->data < 0)
            $this->data *= -1;
        return ($this);
    }
}