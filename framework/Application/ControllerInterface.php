<?php

declare(strict_types=1);

namespace framework\Application;

/**
 * Interface ControllerInterface
 * @package framework\Application
 */
interface ControllerInterface
{
    /**
     * return the default template of the controller
     * @return string
     */
    public function defaultTemplate():string;
}