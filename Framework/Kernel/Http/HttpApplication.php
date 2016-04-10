<?php

namespace Framework\Kernel\Http;

use Framework\Kernel\Application\Application;
use Framework\Kernel\Types\Type;

class HttpApplication extends Application
{
    public function __construct($server)
    {
        $server = Type::getOriginal($server);
    }
}