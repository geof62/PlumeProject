<?php

declare(strict_types=1);

namespace framework\Database\models;

use framework\Config\models\Config;

class MysqlDB extends Database
{
    public function getDns():string
    {
        return ('mysql:dbname=' . $this->config->get('Database/database' . ';host=' . $this->config->get('Database/host')));
    }
}