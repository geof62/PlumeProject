<?php

declare(strict_types=1);

namespace framework\Template\models;

class JsonTemplate extends Template
{
    protected $data = [];

    public function setHeaderType(string $string):Template
    {
        $this->headerType = Response::HeadersType['json'];
        return ($this);
    }

    protected function addNode(string $key, $value)
    {
        $this->data[$key] = $value;
        return ($this);
    }

    public function render():string
    {
        header('Content-type: ' . $this->headerType);
        $result = json_encode($this->data);
        return ($result);
    }
}