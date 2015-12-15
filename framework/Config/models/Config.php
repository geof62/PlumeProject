<?php

declare(strict_types=1);

namespace framework\Config\models;

class Config
{
    protected $data = [];
    protected $dataModules = [];

    public function __construct(string $file)
    {
        $conf = incAbs($file);
        $this->addConfig($conf);
    }

    public function addConfig(array $config):self
    {
        foreach ($config as $k => $v)
        {
            if (preg_match("#^\\#[a-zA-Z]*$#", $k))
                $this->addModConfiguration($k, $v);
            else
                $this->data[$k] = $v;
        }
        return ($this);
    }

    public function addModConfiguration(string $mod, string $file):self
    {
        return $this;
    }

    /*
     * $config : conf/conf/confName;
     * $this return only general conf
     */
    public function getConfig(string $config)
    {
        $conf = explode('/', $config);
        $c = $this->data;
        foreach ($conf as $v)
        {
            if (!array_key_exists($v, $c))
                return (NULL);
            $c = $c[$v];
        }
        if (!is_array($c))
            return ($c);
        return (NULL);
    }

    /*
     * first, this function search in the $mod configuration, after in the general configuration
     */
    public function getModConf(string $mod, string $conf)
    {

    }
}