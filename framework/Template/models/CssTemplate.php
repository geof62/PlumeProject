<?php

declare(strict_types=1);

namespace framework\Template\models;

/**
 * Class CssTemplate.
 * load Css files
 *
 * @package framework\Template\models
 */
class CssTemplate extends Template
{
    /**
     * content the file
     * @var string
     */
    protected $data = "";

    /**
     * return the content type 'css'
     * @return string
     */
    public function getType():string
    {
        return('css');
    }

    /**
     * load the file
     *
     * @param string $view
     * @param array $params
     * @return CssTemplate
     */
    public function loadView(string $view, array $params = []):self
    {
        $this->data = getFileContentAbs($view);
        return ($this);
    }

    /**
     * put the file
     */
    public function put()
    {
        echo $this->data;
    }
}