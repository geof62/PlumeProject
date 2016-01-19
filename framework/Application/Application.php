<?php

declare(strict_types=1);

namespace framework\Application;

class Application
{
    protected $config;
    protected $request;
    protected $router;
    protected $response;

    public function __construct()
    {
    }
}