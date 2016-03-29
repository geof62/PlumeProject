<?php

declare(strict_types=1);

namespace framework\Database\models;

use framework\Config\models\Config;

class ManangeDatabaseConnections
{
    public static function connect(Config $config):Database
    {
        if ($config->get('Database/enable') === true)
        {
            if ($config->get('Database/type') == "mysql")
            {
                $db = new MysqlDB($config);
                return ($db);
            }
            else
                return (NULL);
        }
        else
            return (NULL);
    }
}