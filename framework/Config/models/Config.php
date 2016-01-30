<?php

declare(strict_types=1);

namespace framework\Config\models;

/**
 * Class Config
 * @package framework\Config\models
 */
class Config
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Config constructor.
     * @param callable $config
     */
    public function __construct(callable $config)
    {
        $this->data = $config();
    }

    /**
     * get a parameter by is name
     * @param string $key
     * @return array|null
     */
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