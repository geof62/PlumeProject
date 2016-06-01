<?php

namespace Framework\Kernel\Exception;

class ErrorException extends Exception
{
    public function __construct(int $errno, string $errstr, string $errfile, int $errline, array $errcontext)
    {
        $this->file = $errfile;
        $this->line = $errline;
        $this->code = $errno;
        $this->message = $errstr;
        $this->trace = $errcontext;
    }
}