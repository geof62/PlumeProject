<?php

$config = [
    'site' => [
      'baseUrl' => 'http://geof2.azurewebsites.net/'
    ],
    'Router' => [
        'fileRoutes' => 'app/router/routes.php',
        'stylesPrefix' => 'web/css',
        'scriptsPrefix' => 'web/js'
    ],
    'Database' => [
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'root',
        'database' => 'yo'
    ],
    '#modName' => 'file.php' // charge la configuration d'un module;
];

return ($config);