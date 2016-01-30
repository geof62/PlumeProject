<?php

declare(strict_types=1);

namespace framework\Template\models;

/**
 * Class JsTemplate.
 * load Js Files
 *
 * @package framework\Template\models
 */
class JsTemplate extends Template
{
    /**
     * content of the file
     * @var string
     */
    protected $data = "";

    /**
     * return the content type 'js'
     * @return string
     */
    public function getType():string
    {
        return('js');
    }

    /**
     * load the file
     *
     * @param string $view
     * @param array $params
     * @return JsTemplate
     */
    public function loadView(string $view, array $params = []):self
    {
        $this->data = file_get_contents($view);
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