<?php

declare(strict_types=1);

namespace framework\Template\models;

use framework\Exceptions\models\Exception;

class CssTemplate extends Template
{
    protected $data;

    public function __construct(string $css)
    {
        if (file_exists(RACINE . DIR_DELIMITER . 'web' . DIR_DELIMITER . 'css' . DIR_DELIMITER . $css . '.css'))
        {
            $this->data = file_get_contents(RACINE . DIR_DELIMITER . 'web' . DIR_DELIMITER . 'css' . DIR_DELIMITER . $css . '.css');
        }
        else
            throw new Exception("404");
    }

    public function contentType():string
    {
        return ('css');
    }

    public function render():string
    {
        return ($this->data);
    }
}