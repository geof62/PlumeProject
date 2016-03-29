<?php

declare(strict_types=1);

namespace app\router;

use framework\Router\models\Route;
use framework\Router\models\RouteCollection;

$routes = function(){
    $r = new RouteCollection([
        (new Route("index"))->setController("src\\Page\\Controller\\Default")
                            ->setGet("index")
                            ->setName("index"),
        (new Route("index/id-{id}", ['id' => "[0-9]"]))
                            ->setController("src\\Page\\Controller\\Default")
                            ->setGet("salut")
                            ->setName("salut")
    ]);
    return ($r);
};

return ($routes);