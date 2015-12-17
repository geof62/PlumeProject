<?php

declare(strict_types=1);

namespace app\router;

use framework\Router\models\Route;
use framework\Router\models\RouteCollection;

$routes = function(){
    $r = new RouteCollection(function() {return ([
        new Route("index", [], ['ctrl' => 'General', 'action' => 'index']),
        new Route("index/{id}", ['id' => '[0-9]{2,4}'], ['ctrl' => 'Global', 'action' => 'index2']),
        new Route("index/{id}/yo-{date}", ['id' => '[0-9]{2,4}', 'date' => '[0-9]*'], ['ctrl' => 'Global', 'action' => 'index3'], ['POST'])
        // tester les méthodes
    ]);
    });
    return ($r);
};

return ($routes);