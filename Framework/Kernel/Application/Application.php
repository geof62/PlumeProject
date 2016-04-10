<?php

namespace Framework\Kernel\Application;

abstract class Application implements ApplicationInterface
{
    protected $request;
    protected $response;
}