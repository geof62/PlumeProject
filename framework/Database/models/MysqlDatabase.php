<?php

declare(strict_types=1);

namespace framework\Database\models;

use framework\Config\models\Config;

class MysqlDatabase extends Database
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
    }

    public function connect():Database
    {
        return ($this);
    }

    public function request(string $req, string $type='EXEC'):\PDOStatement
    {

    }
}