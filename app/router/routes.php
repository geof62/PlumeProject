<?php

declare(strict_types=1);

namespace app\router;

use framework\Router\models\Route;
use framework\Router\models\RouteCollection;

$routes = function(){
    $r = new RouteCollection(function() {return (
        new Route("index", [], ['ctrl' => 'Global', 'action' => 'index'])
    );
    });
    return ($r);
};

return ($routes);