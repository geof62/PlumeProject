<?php

declare(strict_types=1);

namespace framework\Template\models;

use framework\Application\Application;

/**
 * Class Template.
 *
 * @package framework\Template\models
 */
abstract class Template implements TemplateInterface
{
    /**
     * Template constructor.
     * @param array $varia list of variables for views
     */
    final public function __construct(array $varia = [])
    {
        $this->variables = $varia;
    }

    /**
     * add a variable to the template
     *
     * @param string $name
     * @param $content
     * @return Template
     */
    final public function addVar(string $name, $content):self
    {
        $this->variables[$name] = $content;
        return ($this);
    }

    /**
     * get a variable by is name
     *
     * @param string $name
     * @return null
     */
    final public function get(string $name)
    {
        if (array_key_exists($name, $this->variables))
            return ($this->variables[$name]);
        return (NULL);
    }
}