<?php

declare(strict_types=1);

namespace framework\Template\models;

use framework\Exceptions\models\Exception;

class JsTemplate extends Template
{
    protected $data;

    public function __construct(string $js)
    {
        if (file_exists(RACINE . DIR_DELIMITER . 'web' . DIR_DELIMITER . 'js' . DIR_DELIMITER . $js . '.js')) {
            $this->data = file_get_contents(RACINE . DIR_DELIMITER . 'web' . DIR_DELIMITER . 'js' . DIR_DELIMITER . $js . '.js');
        } else
            throw new Exception("404");
    }

    public function contentType():string
    {
        return ('js');
    }

    public function render():string
    {
        return ($this->data);
    }
}