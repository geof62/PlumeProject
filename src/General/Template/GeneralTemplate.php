<?php

declare(strict_types=1);

namespace src\General\Template;

use framework\Config\models\Config;
use framework\Template\models\HtmlTemplate;

class GeneralTemplate extends HtmlTemplate
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->loadView('general.html');
        $this->setScript('https://code.angularjs.org/2.0.0-beta.0/angular2-polyfills.js')
            ->setScript('https://code.angularjs.org/2.0.0-beta.0/Rx.umd.js')
            ->setScript('https://code.angularjs.org/2.0.0-beta.0/angular2-all.umd.dev.js');
        $this->setStyle($this->generateBaseUrlStyle() . 'general');
    }
}