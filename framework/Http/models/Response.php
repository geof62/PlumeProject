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

    protected function setTemp(Template $tmp):self
    {
        $this->tmp = $tmp;
        return ($this);
    }
}