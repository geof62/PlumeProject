<?php

declare(strict_types=1);

namespace framework\Router\models;

interface RouteInterface
{
    public function search(string $url);
    public function isFind():bool;
    public function getFind():FindRoute;
}