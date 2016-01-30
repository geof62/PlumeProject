<?php

declare(strict_types=1);

namespace framework\Exception\models;

/**
 * Class Exception.
 * framework exceptions
 *
 * @package framework\Exception\models
 */
class Exception extends \Exception
{
    /**
     * Exception constructor.
     * @param string $message
     * @param int $code
     * @param Exception|NULL $previous
     */
    public function __construct(string $message, int $code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }
}