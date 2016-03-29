<?php

return (function ()
{
    $config = [
        'site' => [
            'baseConfig' => 'app/app',
            'baseUrl' => 'http://geof2.azurewebsites.net/',
        ],
        'Api' => [
            'prefixUrl' => 'api',
            'front' => 'web/pages/front.html'
        ],
        'Router' => [
            'baseRouter' => 'router/router.php',
            'stylesPrefix' => 'css',
            'cssController' => 'framework\\Application\\ParticularController\\Css',
            'scriptsPrefix' => 'js',
            'scriptsController' => 'framework\\Application\\ParticularController\\Js'
        ],
        'Translation' => [
            'enable' => true,
            'baseTranslation' => 'translation/translation.php'
        ],
        'Database' => [
            'enable' => true,
            'type' => "mysql",
            'host' => 'localhost',
            'user' => 'root',
            'password' => 'root',
            'database' => 'yo'
        ],
        '#exampleModule' => 'exampleModule/config/config.php' // charge la configuration d'un module;
    ];

    return ($config);
});