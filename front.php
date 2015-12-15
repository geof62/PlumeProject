<?php

declare(strict_types=1);
@ini_set('display_errors', 'on');

if (empty($_GET) || !array_key_exists('url', $_GET))
{
    echo("Internal Error : no url specify");
    exit();
}

var_dump($_SERVER);

define('RACINE', $_SERVER['PHP_SELF']);

include_once("autoload.php");
$autoload = new SplClassLoader();
$autoload->register();

$config = new \framework\Config\models\Config("app/config/config.php");
$request = new \framework\Http\models\Request($_SERVER);
$router = new \framework\Router\models\Router($request, $config);