<?php

namespace Framework\Kernel\Types;

interface TypeInterface
{
    public function get();
    public function g();
    public function set($value);
    public function __construct($value = NULL);
    public function dup();
}