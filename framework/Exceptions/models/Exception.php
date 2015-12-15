<?php

declare(strict_types=1);

namespace framework\Exceptions\models;

class Exception extends \Exception
{
    public function __construct($message, $code=0, Exception $previous=NULL)
    {
        parent::__construct($message, $code, $previous);
    }
}