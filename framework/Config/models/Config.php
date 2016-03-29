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
     * @var array
     */
    protected $modulesData = [];

    /**
     * Config constructor.
     * @param callable $config
     */
    public function __construct(callable $config)
    {
        $this->data = $config();
        $this->searchModulesConfig();
    }

    protected function searchModulesConfig():self
    {
        foreach ($this->data as $k => $v)
        {
            if (substr($k, 0, 1) == "#")
            {
                $this->modulesData[substr($k, 1)] = new Config(incAbs($this->get('site/baseConfig') . '/' . $v));
                unset($this->data[$k]);
            }
        }
        return ($this);
    }

    public function getModule(string $mod, string $key)
    {
        if (!array_key_exists($mod, $this->modulesData))
            return (NULL);
        return ($this->modulesData[$mod]->get($key));
    }

    /**
     * get a parameter by is name
     *
     * to get a module use 'moduleName:config/in/module'
     * or current syntax : 'moduleName/config/in/module'
     * /!\ last syntax search first the config in the global configuration, and go search in modules after
     *
     * @param string $key
     * @return array|null
     */
    public function get(string $key)
    {
        $mods = explode(':', $key);
        if (count($mods) == 2)
            return ($this->getModule($mods[0], $mods[1]));
        unset($mods);
        $g = explode('/', $key);
        $search = $this->data;
        if (!array_key_exists($g[0], $this->data))
        {
            $a = $g[0];
            unset($g[0]);
            return ($this->getModule($a, implode('/', $g)));
        }
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