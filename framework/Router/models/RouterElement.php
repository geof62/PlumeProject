<?php

declare(strict_types=1);

namespace framework\Router\models;

abstract class RouterElement
{
    public static function cleanRoute(string $route):string
    {
        return (trim($route, '/'));
    }
}