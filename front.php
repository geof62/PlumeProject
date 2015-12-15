<?php

declare(strict_types=1);
@ini_set('display_errors', 'on');

if (empty($_GET) || !array_key_exists('url', $_GET))
{
    echo("Internal Error : no url specify");
    exit();
}

define('RACINE', getcwd());
define('DIR_DELIMITER', '\\');

function incAbs(string $path)
{
    $a = include(RACINE . DIR_DELIMITER . str_replace('/', DIR_DELIMITER, $path));
    return ([]);
}


include_once("autoload.php");
$autoload = new SplClassLoader();
$autoload->register();

$config = new \framework\Config\models\Config("app/config/config.php");
$request = new \framework\Http\models\Request($_SERVER);
$router = new \framework\Router\models\Router($request, $config);