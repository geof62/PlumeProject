<?php

declare(strict_types=1);

namespace framework\Database\models;

use framework\Config\models\Config;

interface DatabaseInterface
{
    public function getDns():string;
}