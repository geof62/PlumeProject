<?php

declare(strict_types=1);

namespace framework\Template\models;

class CssTemplate extends Template
{
    protected $data = "";

    public function getType():string
    {
        return('css');
    }

    public function loadView(string $view, array $params = []):self
    {
        $this->data = getFileContentAbs($view);
        return ($this);
    }

    public function put()
    {
        echo $this->data;
    }
}