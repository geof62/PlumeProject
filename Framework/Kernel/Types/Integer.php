<?php

namespace Framework\Kernel\Types;

use Framework\Kernel\Exception\Exception;

class Integer
    extends Type
{
    public function __construct($value = NULL)
    {
        $this->set($value);
    }

    public function dup()
    {
        return (new self($this));
    }

    public function set($value):self
    {
        if ($value === NULL)
            $this->data = NULL;
        else if (is_int($value))
            $this->data = $value;
        else if ($value instanceof Integer)
            $this->data = $value->get();
        else
            throw new TypeException("Invalid Value for the Type Int");
        return ($this);
    }

    public function add(Integer $nb):self
    {
        $this->data += $nb->get();
        return ($this);
    }

    public function sub(Integer $nb):self
    {
        $this->data -= $nb->get();
        return ($this);
    }

    public function div(Integer $nb):self
    {
        if ($nb->get() == 0)
            throw new TypeException("Division by Zero");
        $this->data = (int)($this->data / $nb->get());
        return ($this);
    }

    public function mult(Integer $nb):self
    {
        $this->data *= $nb->get();
        return ($this);
    }

    public function modulo(Integer $nb):self
    {
        if ($nb->get() == 0)
            throw new TypeException("Division by Zero");
        $this->data %= $nb->get();
        return ($this);
    }

    public function abs():self
    {
        if ($this->data < 0)
            $this->data *= -1;
    }

    public function pow(Integer $pow):self
    {
        if ($pow->isNull())
            return ($this);
            $this->data = (int)(pow($this->data, $pow->get()));
        return ($this);
    }
    
    // Sqrt
}