<?php

declare(strict_types=1);

namespace framework\Utilities;

use framework\Exceptions\models\Exception;

abstract class Controller implements ControllerInterface
{
    protected $response;

    public function loadTemplate(string $tmp):self
    {
        $tmp = explode(':', $tmp);
        if (count($tmp) == 1)
            $tmp = "src\\General\\Template\\" . $tmp[0] . "Template";
        else
            $tmp = "src\\" . $tmp[0] . "\\Template\\" . $tmp[1] . "Template";
        if (!class_exists($tmp))
            throw new Exception("invalid template");
        $this->response->setTemp(new $tmp());
        return ($this);
    }
}