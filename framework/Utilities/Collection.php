<?php

declare(strict_types=1);

namespace framework\Utilities;

use framework\Exceptions\models\Exception;

abstract class Collection
{
    protected $data = [];

    protected function addNode($value, $key=NULL, bool $overwrite=true):self
    {
        if ($key == NULL)
            $this->data[] = $value;
        else if (in_array($key, $this->data))
        {
            if ($overwrite == true)
                $this->data[$key] = $value;
        }
        else
            $this->data[$key] = $value;
        return ($this);
    }

    public function getNode($key, bool $exception=false)
    {
        if (in_array($key, $this->data))
            return ($this->data[$key]);
        if ($exception == true)
            throw new Exception("Node width key : " . $key . " doesn't exist.");
        else
            return (NULL);
    }

    public function getAll():array
    {
        return ($this->data);
    }

    public function length():int
    {
        return (count($this->data));
    }
}