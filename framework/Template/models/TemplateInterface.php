<?php

declare(strict_types=1);

namespace framework\Template\models;

Interface TemplateInterface
{
    public function setHeaderType(string $string):Template;

    public function render():string;
}