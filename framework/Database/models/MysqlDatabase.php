<?php

declare(strict_types=1);

namespace framework\Database\models;

use framework\Config\models\Config;
use framework\Exceptions\models\Exception;

class MysqlDatabase extends Database
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
    }

    public function connect():Database
    {
        $this->instance = new PDO('host=' . $this->host . ';dbname=' . $this->name, $this->user, $this->password);
        return ($this);
    }

    public function quote(string $str):string
    {
        return ($this->instance->quote($str));
    }

    public function request(string $req, string $type='exec'):\PDOStatement
    {
        if ($type != "exec" && $req != "")
            throw new Exception("Invalid Database Request");
        $res = $this->instance->$type($req);
        return ($res);
    }
}