<?php

declare(strict_types=1);

namespace framework\Http\models;

use framework\Template\models\Template;

class Response
{
    const HeadersType = [
        'html' => 'text/html',
        'js' => 'text/javascript',
        'css' => 'text/css',
        'json' => 'application/json',
        'pdf' => 'application/pdf',
        'txt' => 'text/plain',
        'xml' => 'text/xml'
    ];

    protected $temp;

    public function __construct()
    {
    }

    public function setTemp(Template $tmp):self
    {
        $this->temp = $tmp;
        return ($this);
    }

    public function put()
    {
        echo $this->temp->render();
    }
}