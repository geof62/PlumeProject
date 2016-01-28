<?php

declare(strict_types=1);

$f = function($params)
{
    $ret = "<p>hello world</p>";
    if (array_key_exists('id', $params))
        $ret = "thuglife id : " . $params['id'];
    return ($ret);
};
return ($f);