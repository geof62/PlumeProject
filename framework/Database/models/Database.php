<?php

declare(strict_types=1);

namespace framework\Database\models;

use framework\Config\models\Config;
use framework\Exception\models\Exception;

/**
 * Class Database.
 * when this abstract class is extended, autoconnect the database by config
 * @package framework\Database\models
 */
abstract class Database extends \PDO implements DatabaseInterface
{
    /**
     * the safeguard of the config
     * @var Config
     */
    protected $config;

    /**
     * Database constructor.
     * @param Config $config
     */
    final public function __construct(Config $config)
    {
        $this->config = $config;
        if ($this->config->get('Database/enable') === false)
            throw new Exception("Impossible to connect with DB, please enable it");
        parent::__construct($this->getDns(), $this->config->get('Database/user'), $this->config->get('Database/password'));
    }
}