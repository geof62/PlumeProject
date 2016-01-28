<?php

declare(strict_types=1);

namespace framework\Template\models;

class JsTemplate extends Template
{
    protected $data = "";

    public function getType():string
    {
        return('js');
    }

    public function loadView(string $view, array $params = []):self
    {
        $this->data = file_get_contents($view);
        return ($this);
    }

    public function put()
    {
        echo $this->data;
    }
}