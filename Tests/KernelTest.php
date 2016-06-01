<?php

namespace Tests;

use Framework\Kernel\Exception\Exception;
use Framework\Kernel\Types\Integer;

class KernelTest
{
    public function testExceptionHandler()
    {
        throw new \Exception("this is an exception");
    }

    public function testException()
    {
        throw new Exception("this a personal exception");
    }

    public function testTypeException()
    {
        $t = new Integer("impossible");
    }

    public function __construct()
    {
        // $this->testExceptionHandler();
        // $this->testException();
        $this->testTypeException();
        echo "all is ok\n";
    }
}