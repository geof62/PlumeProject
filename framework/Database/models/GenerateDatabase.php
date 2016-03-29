<?php

declare(strict_types=1);

namespace framework\Database\models;

use framework\Config\models\Config;

/**
 * Class GenerateDatabase.
 * Parse the array given in constructor to get ORM() method and create a database
 * @package framework\Database\models
 */
class GenerateDatabase
{
    /**
     * GenerateDatabase constructor.
     *
     * @param Database $db
     * @param array $entities sous forme d'instance
     */
    public function __construct(Database $db, array $entities)
    {

    }
}