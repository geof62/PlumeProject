<?php

declare(strict_types=1);

namespace src\General\Template;

use framework\Template\models\HtmlTemplate;

class GeneralTemplate extends HtmlTemplate
{
    public function __construct()
    {
        $this->loadView('general.html');
    }
}