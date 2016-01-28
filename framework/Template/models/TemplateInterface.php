<?php

declare(strict_types=1);

namespace framework\Template\models;

interface TemplateInterface
{
    public function put();

    public function getType():string;

    public function loadView(string $view, array $params = []);
}