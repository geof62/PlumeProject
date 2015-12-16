<?php

declare(strict_types=1);

namespace app\router;

use framework\Router\models\Route;
use framework\Router\models\RouteCollection;

$routes = function(){
    $r = new RouteCollection(function() {return ([
        new Route("index", [], ['ctrl' => 'Global', 'action' => 'index']),
        new Route("index/{id}", ['id' => '[0-9]{2,4}'], ['ctrl' => 'Global', 'action' => 'index2'])
        // tester les méthodes
    ]);
    });
    return ($r);
};

return ($routes);