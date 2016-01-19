<?php

declare(strict_types=1);

namespace framework\Utilities;

abstract class Collection
{
    protected $data = [];

    public function __construct(array $data = [])
    {
        $this->addData($data);
    }

    public function addData(array $data, bool $key = false):self
    {
        foreach($data as $k => $v)
        {
            if ($key == true)
                $this->addNode($v, $k);
            else
                $this->addNode($v);
        }
        return ($this);
    }

    public function addNode($value, string $key = NULL, bool $replace = true):self
    {
        if ($key == NULL)
            $this->data[] = $value;
        else if (in_array($key, $this->data) && $replace == true)
            $this->data[$key] = $value;
        else if (!in_array($key, $this->data))
            $this->data[$key] = $value;
        return ($this);
    }

    public function delNode(string $key):self
    {
        if (in_array($key, $this->data))
            unset($this->data[$key]);
        return ($this);
    }

    public function clear():self
    {
        $this->data = [];
        return ($this);
    }
}