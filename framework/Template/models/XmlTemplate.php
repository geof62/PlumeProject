<?php

declare(strict_types=1);

namespace framework\Template\models;

class XmlTemplate extends Template
{
    protected $data;

    public function __construct()
    {

    }

    public function contentType():string
    {
        return ('xml');
    }

    public function loadView(string $file):self
    {
        return ($this);
    }

    public function render():string
    {
        return ($this->data);
    }
}