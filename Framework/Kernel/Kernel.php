<?php

namespace Framework\Kernel;

use Framework\Kernel\Exception\Exception;
use Framework\Kernel\Exception\ExceptionManage;

/**
 * load components of the framework
 * Class Kernel
 * @package Framework\Kernel
 */
abstract class Kernel
{
    private static $exception_manager = ExceptionManage::class;

    private static function start_exceptions_catching()
    {
        set_error_handler(function (int $errno, string $errstr, string $errfile, int $errline, array $errcontext) {
            throw new Exception($errno, $errstr, $errfile, $errline, $errcontext);
        });
        set_exception_handler(function(\Throwable $exception){
            new self::$exception_manager($exception);
        });
    }

    public static function setExceptionManager($manager)
    {
        if (!class_exists($manager))
            throw new Exception("invalid exception manager");
        self::$exception_manager = $manager;
        self::start_exceptions_catching();
    }

    final public static function start()
    {
        self::start_exceptions_catching();
    }
}