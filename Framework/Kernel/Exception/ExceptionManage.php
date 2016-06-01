<?php

namespace Framework\Kernel\Exception;

class ExceptionManage
{
    protected $exception;

    public function __construct(\Throwable $exception)
    {
        $this->exception = $exception;
        $this->putException();
        exit();
    }

    public function putException():self
    {
        echo $this->exception->__toString();
        return ($this);
    }
}