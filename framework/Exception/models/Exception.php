<?php

declare(strict_types=1);

namespace framework\Exception\models;

class Exception extends \Exception
{
    public function __construct(string $message, int $code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }
}