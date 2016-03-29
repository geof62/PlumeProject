<?php

declare(strict_types=1);

namespace framework\Router\models;

use framework\Config\models\Config;

/**
 * Class RouterLanguage.
 * This class is add a languages gestion for the Router
 *
 * @package framework\Router\models
 */
class RouterLanguage extends Router
{
    /**
     * Liste des abréviations de langues possibles.
     *
     * @var array
     */
    protected $langAvailable = [];

    /**
     * Langue détectée
     *
     * @var string
     */
    protected $langDetect;

    /**
     * true if a language is detected
     * @var bool
     */
    protected $detect = false;

    /**
     * language per Default
     *
     * @var string
     */
    protected $langDefault = "en";

    /**
     * RouterLanguage constructor.
     *
     * @param callable $routeCollection return of a router's config file
     * @param callable $languagesCollection return of a translation's config file
     * @param Config $config instance of config
     */
    public function __construct(callable $routeCollection, callable $languagesCollection, Config $config)
    {
        parent::__construct($routeCollection, $config);
        $this->langAvailable = $languagesCollection();
    }

    /**
     * add a language avaible to the router.
     *
     * @param string $lang
     * @return RouterLanguage
     */
    public function addLang(string $lang):self
    {
        if (!in_array($lang, $this->langAvailable))
            $this->langAvailable[] = $lang;
        return ($this);
    }

    /**
     * search if an url matched to any Route
     *
     * @param string $url the url to search
     * @return RouterLanguage
     */
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