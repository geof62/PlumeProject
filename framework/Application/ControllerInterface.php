<?php

declare(strict_types=1);

namespace framework\Application;

interface ControllerInterface
{
    public function defaultTemplate():string;
}