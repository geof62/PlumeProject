<?php

namespace Framework\Kernel\Types;

class Collection extends Type implements \ArrayAccess
{
    public function __construct(array $arr = [])
    {
        $this->content = $arr; 
    }
    
    public function getNode($key)
    {
        $key = Type::getOriginal($key);
        if (array_key_exists($key, $this->g()))
            return ($this->get()[$key]);
        return (NULL);
    }

    public function setNode($key, $value):self
    {
        $key = Type::getOriginal($key);
        $this->content[$key] = $value;
        return ($this);
    }

    public function delNode($key)
    {
        $key = Type::getOriginal($key);
        if ($this->keyExists($key))
            unset($this->content[$key]);
        return ($this);
    }
    
    public function keyExists($key):bool
    {
        $key = Type::getOriginal($key);
        if (array_key_exists($key, $this->get()))
            return (TRUE);
        return (FALSE);
    }

    public function implode($glue):Str
    {
        $glue = Type::getOriginal($glue);
        $str = new Str();
        foreach ($str as $v)
        {
            $str->add($v);
            $str->add($glue);
        }
        $str->set(substr($str->g(), 0, - strlen($glue)));
    }

    public function inArray($value):bool
    {
        $value = Type::getOriginal($value);
        foreach ($this->content as $v)
        {
            if ($v === $value)
                return (TRUE);
        }
        return (FALSE);
    }

    public function merge(Collection $collection):self
    {
        $this->content = $this->merge($this->content, $collection->g());
        return ($this);
    }

    public function count():Real
    {
        return (new Real(count($this->content)));
    }

    /*
     * implements array access methods
     */

    public function offsetGet($offset)
    {
        return ($this->get($offset));
    }

    public function offsetExists($offset)
    {
        return ($this->keyExists($offset));
    }

    public function offsetSet($offset, $value)
    {
        return ($this->setNode($offset, $value));
    }

    public function offsetUnset($offset)
    {
        return ($this->delNode($offset));
    }
}