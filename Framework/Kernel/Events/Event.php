<?php

namespace Framework\Kernel\Events;

final class Event
{
    protected $action;

    public function __construct(callable $action)
    {
        $this->action = $action;
    }

    public function trigger()
    {
        return ($this->action);
    }
}