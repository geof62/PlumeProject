<?php

return (function ()
{
    $config = [
        'site' => [
            'baseUrl' => 'http://geof2.azurewebsites.net/',
        ],
        'Api' => [
            'prefix' => 'api',
            'front' => 'pages/front.html'
        ],
        'Router' => [
            'stylesPrefix' => 'css',
            'cssController' => 'framework\\Application\\ParticularController\\Css',
            'scriptsPrefix' => 'js',
            'scriptsController' => 'framework\\Application\\ParticularController\\Js'
        ],
        'Translation' => [
            'enable' => true,
            'file' => 'translation/translation.php'
        ],
        'Database' => [
            'enable' => true,
            'host' => 'localhost',
            'user' => 'root',
            'password' => 'root',
            'database' => 'yo'
        ],
        '#modName' => 'file.php' // charge la configuration d'un module;
    ];

    return ($config);
});