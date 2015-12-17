<?php

declare(strict_types=1);

namespace framework\Template\models;

abstract class Template implements TemplateInterface
{
    protected $headerType;

    public function getHeaderType():string
    {
        return $this->headerType;
    }
}