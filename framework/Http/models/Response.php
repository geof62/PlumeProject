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
    protected $contentType;

    public function __construct($head = 'html')
    {
        $this->contentType = $head;
    }

    public function header():self
    {
        header('Content-type: ' . self::HeadersType[$this->contentType]);
    }

    public function setTemp(Template $tmp):self
    {
        $this->temp = $tmp;
        return ($this);
    }

    public function put()
    {
        $this->header();
        echo $this->temp->render();
    }
}