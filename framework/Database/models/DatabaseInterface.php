<?php

declare(strict_types=1);

namespace framework\Database\models;

interface DatabaseInterface
{
    public function connect():Database;
}