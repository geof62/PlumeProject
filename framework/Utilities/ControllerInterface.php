<?php

declare(strict_types=1);

namespace framework\Utilities;

interface ControllerInterface
{
    public function loadResponse():Controller;
}