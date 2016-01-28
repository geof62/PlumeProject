<?php

declare(strict_types=1);

namespace framework\Template\models;

use framework\Application\Application;

abstract class Template implements TemplateInterface
{
    final public function __construct(array $varia = [])
    {
        $this->variables = $varia;
    }

    final public function addVar(string $name, $content):self
    {
        $this->variables[$name] = $content;
        return ($this);
    }

    final public function get(string $name)
    {
        if (array_key_exists($name, $this->variables))
            return ($this->variables[$name]);
        return (NULL);
    }
}