<?php

declare(strict_types=1);

namespace framework\Template\models;

class HtmlTemplate extends Template
{
    protected $data = "";

    public function getType():string
    {
        return ('html');
    }

    public function loadView(string $view, array $params = []):self
    {
        $view = explode(':', $view);
        $view = 'src/' . $view[0] . '/View/' . $view[1] . '.php';
        $t = incAbs($view);
        $this->data = $t($params);
        return ($this);
    }

    public function put():self
    {
        echo $this->data;
        return ($this);
    }
}