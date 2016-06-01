<?php

declare(strict_types=1);
@ini_set('display_errors', 'on');

/*
 * Initiate autoloading
 */
include_once("autoload.php");
$autoload = new SplClassLoader();
$autoload->register();

\Framework\Kernel\Kernel::start();

new \Tests\KernelTest();