<?php

namespace Framework\Kernel\Types;

class Collection
    extends Type
    implements \Iterator
{
    protected $position = 0;
    protected $childrenType = NULL;

    public function __construct($value = NULL)
    {
        $this->set($value);
    }

    public function dup()
    {
        return (new self($this));
    }

    public function set($value)
    {
        if ($value === NULL)
            $this->data = NULL;
        else if (is_array($value) || $value instanceof self)
        {
            $this->data = [];
            foreach ($value as $k => $v)
            {
                if ($this->childrenType !== NULL)
                    if (!Convert::is_type($this->childrenType, $v))
                        throw new TypeException("Values of the array must be of type : " . $this->childrenType);
                $this->data[$k] = $v;
            }
        }
        else
            throw new TypeException("Invalid value given for the type Collection");
        return ($this);
    }

    public function add($value, Type $key = NULL):self
    {
        if ($key === NULL)
            $this->data[] = $value;
        else
        {
            if ($key instanceof Collection)
                throw new TypeException("invalid key in collection");
            $key = $key->get();
            $this->data[$key] = $value;
        }
        return ($this);
    }

    public function key_exists($key):bool
    {
        if ($key instanceof self)
            return (false);
        else if ($key instanceof Type)
            $key = $key->g();
        if (array_key_exists($key, $this->data))
            return (true);
        return (false);
    }

    public function get($key = NULL)
    {
        if ($key == NULL)
            return (parent::get());
        else
        {
            if ($key instanceof Type && !($key instanceof self))
                $key = $key->get();
            else if ($key instanceof Type)
                throw new TypeException("Invalid key given : Collection can't be a key");
            if ($this->key_exists($key))
                return ($this->data[$key]);
        }
        return (NULL);
    }

    public function g($key = NULL)
    {
        return ($this->get($key));
    }

    /**
     * list of parameters :
     * $key : return the current key
     * $value : return the current value (in referencing, you also can directly edit it)
     * $tab : return an auto-referencing of the Collection
     * others parameters, given in order to the callable
     * @return Collection
     * @throws TypeException
     */
    public function foreach():self
    {
        $args = func_get_args();
        if (!is_callable($args[0]))
            throw new TypeException("First paramter of foreach() have to be a callable");
        foreach ($this as $k => $v)
        {
            $params = [
                $k,
                &$v,
                $this,
            ];
            foreach ($args as $arg_k => $arg)
            {
                if ($k != 0)
                    $params[] = $arg;
            }
            call_user_func_array($args[0], $params);
        }
        return ($this);
    }

    public function length():int
    {
        if ($this->data === NULL)
            return (0);
        return (count($this->data));
    }

    /*
     * Iterator functions
     */

    /**
     * Reinitialize the position
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * get the current value
     * @return mixed
     */
    public function current()
    {
        return ($this->data[array_keys($this->data)[$this->position]]);
    }

    /**
     * get the current key
     * @return mixed
     */
    public function key()
    {
        return (array_keys($this->data)[$this->position]);
    }

    /**
     * go to the next key
     */
    public function next()
    {
        $this->position += 1;
    }

    /**
     * return true if the current position is valid
     * @return bool
     */
    public function valid()
    {
        return (isset($this->data[array_keys($this->data)[$this->position]]));
    }
}