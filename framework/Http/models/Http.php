<?php

declare(strict_types=1);

namespace framework\Http\models;

abstract class Http
{
    public static $methods = [
        'ALL' => 0,
        'GET' => 1,
        'POST' => 2,
        'PUT' => 3,
        'DEL' => 4
    ];

    public static $defaultMethod = 0;

    static public function getMethod(string $method):int
    {
        $method = strtoupper($method);
        if (array_key_exists($method, self::$methods))
            return self::$methods[$method];
        else
            return (-1);
    }

    static public function getMethodById(int $method):string
    {
        if (in_array($method, self::$methods))
            return (array_keys(self::$methods, $method)[0]);
        else
            return (array_keys(self::$methods, self::$defaultMethod)[0]);
    }

    static public function isMethod(string $method):bool
    {
        if (array_key_exists($method, self::$methods))
            return (true);
        return (false);
    }

    static public function allowMethod(int $method, array $methods)
    {
        if (in_array(Http::getMethod('ALL'), $methods))
            return (true);
        if (in_array($method, $methods))
            return (true);
        return (false);
    }
}