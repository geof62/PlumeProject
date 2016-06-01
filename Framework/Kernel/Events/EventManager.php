<?php

namespace Framework\Kernel\Events;

use Framework\Kernel\Exception\Exception;
use Framework\Kernel\Types\Collection;
use Framework\Kernel\Types\Str;

class EventManager
{
    static protected $events = NULL;

    public static function addEvent(Str $name, Event $event)
    {
        if (self::$events === NULL)
            self::$events = new Collection();
        self::$events->add($name, $event);
    }

    public static function trigger(Str $name)
    {
        if (self::$events === NULL)
            throw new Exception("any event is register");
        if (!self::$events->keyExists($name))
            throw new Exception("the event : " . $name->get() . " doesn't exists");
        self::$events->get($name)->trigger();
    }
}