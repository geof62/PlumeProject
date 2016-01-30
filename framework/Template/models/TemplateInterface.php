<?php

declare(strict_types=1);

namespace framework\Template\models;

/**
 * Interface TemplateInterface.
 * @package framework\Template\models
 */
interface TemplateInterface
{
    /**
     * put the response
     * @return self
     */
    public function put();

    /**
     * return the contentType
     * @return string
     */
    public function getType():string;

    /**
     * Load a view
     *
     * @param string $view
     * @param array $params
     * @return mixed
     */
    public function loadView(string $view, array $params = []);
}