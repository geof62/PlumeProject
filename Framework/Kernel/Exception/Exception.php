<?php

namespace Framework\Kernel\Exception;

class Exception extends \Exception
{
    protected $trace;

    public function __construct($message, $code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return ("\nEXCEPTION\n" . $this->message . "\n" . "file : " . $this->file . "\n" . "line : " . $this->line);
    }
}