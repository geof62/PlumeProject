<?php

declare(strict_types=1);

namespace framework\Database\models;

use framework\Config\models\Config;

abstract class Database implements DatabaseInterface
{
    protected $name;
    protected $host;
    protected $user;
    protected $password;
    protected $instance;

    public function __construct(Config $config)
    {
        $this->setName($config->getConfig('Database/database'))
            ->setHost($config->getConfig('Database/host'))
            ->setUser($config->getConfig('Database/user'))
            ->setPassword($config->getConfig('Database/password'));
    }

    public function setName(string $name):self
    {
        $this->name = $name;
        return ($this);
    }

    public function setHost(string $host):self
    {
        $this->host = $host;
        return ($this);
    }

    public function setUser(string $user):self
    {
        $this->user = $user;
        return ($this );
    }

    public function setPassword(string $password):self
    {
        $this->password = $password;
        return ($this);
    }
}