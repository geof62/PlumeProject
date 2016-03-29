<?php

declare(strict_types=1);
@ini_set('display_errors', 'on');

define('RACINE', getcwd());
define('DIR_DELIMITER', '/');

function incAbs(string $path)
{
    return(include(RACINE . DIR_DELIMITER . str_replace('/', DIR_DELIMITER, $path)));
}

function getFileContentAbs(string $path)
{
    return(file_get_contents(RACINE . DIR_DELIMITER . str_replace('/', DIR_DELIMITER, $path)));
}

include_once("autoload.php");
$autoload = new SplClassLoader();
$autoload->register();

$app = new \framework\Application\Application(incAbs('app/app/config/config.php'));