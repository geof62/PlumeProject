<?php

declare(strict_types=1);

namespace framework\Template\models;

class JsonTemplate extends Template
{
    protected $data = [];

    public function contentType():string
    {
        return ('json');
    }

    protected function addNode(string $key, $value)
    {
        $this->data[$key] = $value;
        return ($this);
    }

    public function render():string
    {
        $result = json_encode($this->data);
        return ($result);
    }
}