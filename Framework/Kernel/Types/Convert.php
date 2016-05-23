<?php

namespace Framework\Kernel\Types;

abstract class Convert
{
    const TYPES = [
        'Integer' => Integer::class,
        'Double' => Double::class,
        'Str' => Str::class,
        'Collection' => Collection::class
    ];

    public static function is_type($type, Type $value):bool
    {
        if ($type instanceof Str)
            $type = $type->get();
        else if (!is_string($type))
            throw new TypeException("invalid $type given");
        if (!in_array($type, self::TYPES))
            return (false);
        if (self::TYPES[$type] === get_class($value))
            return (true);
        return (false);
    }

    public static function toInteger(Type $value):Integer
    {
        if ($value instanceof Double)
            return (new Integer(round($value->get())));
        if ($value instanceof Integer)
            return ($value->dup());
        if ($value instanceof Str)
        {
            if (is_numeric($value->get()))
                return (new Integer((int)($value->get())));
            else
                throw new TypeException("the String isn't numeric");
        }
        throw new TypeException("the Type " . get_class($value) . " can't be convert to Int");
    }

    public static function toStr(Type $value):Str
    {
        if ($value instanceof Str)
            return ($value->dup());
        if ($value instanceof Integer || $value instanceof Double)
            return (new Str("" . $value->get()));
        throw new TypeException("the Type " . get_class($value) . " can't be convert to Str");
    }

    public static function toDouble(Type $value):Double
    {
        if ($value instanceof Integer)
            return (new Double($value->get() * 1.00));
        if ($value instanceof Double)
            return ($value->dup());
        if ($value instanceof Str)
        {
            if (is_numeric($value->get()))
                return (new Double((float)($value->get())));
            else
                throw new TypeException("the String isn't numeric");
        }
        throw new TypeException("the Type " . get_class($value) . " can't be convert to Double");
    }
}