<?php

namespace Framework\Kernel\Types;

class Str extends Type
{
    public function __construct(string $str = "")
    {
        $this->content = $str;
    }
    
    public function set($str):self
    {
        $str = Type::getOriginal($str);
        if (!is_string($str))
            throw new TypeException("set string");
        return ($this);
    }

    public function add($str):self
    {
        $str = Type::getOriginal($str);
        $this->content .= $str;
        return ($this);
    }

    public function strlen():Real
    {
        return (new Real(strlen($this->content)));
    }

    public function substr($begin, $length=NULL):self
    {
        $begin = Type::getOriginal($begin);
        $length = Type::getOriginal($length);
        $this->content = substr($this->content, $begin, $length);
        return ($this);
    }

    public function explode($glue):Collection
    {
        $coll = new Collection(explode($glue, $this->content));
        return ($coll);
    }
}