<?php

declare(strict_types=1);

namespace framework\Config\models;

class Config
{
    protected $data;

    public function __construct(callable $config)
    {
        $this->data = $config();
    }

    public function get(string $key)
    {
        $g = explode('/', $key);
        $search = $this->data;
        foreach ($g as $k => $v)
        {
            if (!array_key_exists($v, $search))
                return (NULL);
            else
                $search = $search[$v];
            if ($k != count($g) - 1 && !is_array($search))
                return (NULL);
        }
        return ($search);
    }
}