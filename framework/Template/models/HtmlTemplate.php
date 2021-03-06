<?php

declare(strict_types=1);

namespace framework\Template\models;

use framework\Config\models\Config;
use framework\Exceptions\models\Exception;
use framework\Http\models\Response;

abstract class HtmlTemplate extends Template
{
    protected $styles = [];
    protected $scripts = [];
    protected $ico = NULL;
    protected $charset = "UTF-8";
    protected $title = "Page";
    protected $data = "";
    protected $config;

    protected function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function contentType():string
    {
        return ('html');
    }

    public function setData(string $data):self
    {
        $this->data = $data;
        return ($this);
    }

    public function loadView(string $view):self
    {
        $view = explode(':', $view);
        if (count($view) == 1)
            $view = RACINE . DIR_DELIMITER . "src" . DIR_DELIMITER . "General" . DIR_DELIMITER . "View" . DIR_DELIMITER . str_replace('/', DIR_DELIMITER, $view[0]);
        else
            $view = RACINE . DIR_DELIMITER . str_replace('/', DIR_DELIMITER, $view[0]) . DIR_DELIMITER . 'View' . DIR_DELIMITER . str_replace('/', DIR_DELIMITER, $view[1]);
        if (!file_exists($view))
            throw new Exception("Invalid view file");
        $this->setData(file_get_contents($view));
        return ($this);
    }

    public function setScript(string $script):self
    {
        $this->scripts[] = $script;
        return ($this);
    }

    public function setStyle(string $style):self
    {
        $this->styles[] = $style;
        return ($this);
    }

    public function prepareData():string
    {
        return ($this->data);
    }

    protected function prepareStyles():string
    {
        $result = "";
        foreach ($this->styles as $v)
        {
            $result .= "<link rel=\"stylesheet\" href=\"$v\" />";
        }
        return ($result);
    }

    protected function prepareHead():string
    {
        $header = "<!DOCTYPE html>\n"
            . "<html>\n"
            . "<head>\n"
            . "<meta charset=\"$this->charset\">\n"
            . "<title>$this->title</title>\n"
            . $this->prepareStyles()
            . "</head>\n"
            . "<body>\n";
        return ($header);
    }

    protected function prepareScripts():string
    {
        $result = "";
        foreach ($this->scripts as $v)
        {
            $result .= "<script src=\"$v\"></script>\n";
        }
        return ($result);
    }

    protected function prepareEnd():string
    {
        $footer = $this->prepareScripts()
            . "</body>\n"
            . "</html>\n";
        return ($footer);
    }

    public function render():string
    {
        $result = $this->prepareHead();
        $result .= $this->prepareData();
        $result .= $this->prepareEnd();
        return ($result);
    }

    public function generateBaseUrlStyle():string
    {
        return ($this->config->getConfig('site/baseUrl') . $this->config->getConfig('Router/stylesPrefix') . "/");
    }
}