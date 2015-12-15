<?php

declare(strict_types=1);

namespace app\router;

use framework\Router\models\Route;
use framework\Router\models\RouteCollection;

$routes = function(){
    $r = new RouteCollection([
        new Route("index", [], ['ctrl' => 'Global', 'action' => 'index'])
    ]);
};

return $routes;