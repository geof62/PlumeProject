<?php

declare(strict_types=1);

namespace framework\Template\models;

Interface TemplateInterface
{
    public function render():string;

    public function contentType():string;
}