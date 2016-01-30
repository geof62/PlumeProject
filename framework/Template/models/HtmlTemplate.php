<?php

declare(strict_types=1);

namespace framework\Template\models;

/**
 * Class HtmlTemplate.
 * load html views
 *
 * @package framework\Template\models
 */
class HtmlTemplate extends Template
{
    /**
     * content of the view
     *
     * @var string
     */
    protected $data = "";

    /**
     * return the content type 'html'
     * @return string
     */
    public function getType():string
    {
        return ('html');
    }

    /**
     * load an html view
     *
     * @param string $view
     * @param array $params
     * @return HtmlTemplate
     */
    public function loadView(string $view, array $params = []):self
    {
        $view = explode(':', $view);
        $view = 'src/' . $view[0] . '/View/' . $view[1] . '.php';
        $t = incAbs($view);
        $this->data = $t($params);
        return ($this);
    }

    /**
     * put the view
     *
     * @return HtmlTemplate
     */
    public function put():self
    {
        echo $this->data;
        return ($this);
    }
}