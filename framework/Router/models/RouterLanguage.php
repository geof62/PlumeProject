<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Config\models\Config;

class RouterLanguage extends Router
{
    protected $langAvailable = [];
    protected $langDetect;
    protected $detect = false;
    protected $langDefault = "en";

    public function __construct(callable $routeCollection, callable $languagesCollection, Config $config)
    {
        parent::__construct($routeCollection, $config);
    }

    public function addLang(array $lang):self
    {
        if (!in_array($lang, $this->langAvailable))
            $this->langAvailable[] = $lang;
        return ($this);
    }

    public function search(string $url):self
    {
        $url = trim($url, '/');
        if (in_array(substr($url, 0, 2), $this->langAvailable))
        {
            $this->langDetect = substr($url, 0, 2);
            $this->detect = true;
            $url = substr($url, 3);
        }
        parent::search($url);
        return ($this);
    }
}