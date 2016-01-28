<?php

declare(strict_types=1);
@ini_set('display_errors', 'on');

if (empty($_GET) || !array_key_exists('url', $_GET))
{
    echo("Internal Error : no url specify");
    exit();
}

define('RACINE', getcwd());
define('DIR_DELIMITER', '/');

function incAbs(string $path)
{
    $a = include(RACINE . DIR_DELIMITER . str_replace('/', DIR_DELIMITER, $path));
    return ($a);
}

function getFileContentAbs(string $path)
{
    $a = file_get_contents(RACINE . DIR_DELIMITER . str_replace('/', DIR_DELIMITER, $path));
    return ($a);
}

include_once("autoload.php");
$autoload = new SplClassLoader();
$autoload->register();

$app = new \framework\Application\Application('app/');