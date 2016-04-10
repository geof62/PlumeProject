<?php

namespace Framework\Kernel\Types;

abstract class Type
{
    protected $content;

    public function g()
    {
        return ($this->g());
    }

    public function get()
    {
        return ($this->content);
    }

    public static function getOriginal($var)
    {
        if ($var instanceof Type)
            return ($var->get());
        return ($var);
    }
}