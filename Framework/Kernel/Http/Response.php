<?php

namespace Framework\Kernel\Http;

use Framework\Kernel\Types\Collection;
use Framework\Kernel\Types\Real;
use Framework\Kernel\Types\Str;

final class Response extends \Framework\Kernel\Application\Response
{
    /* ***************************************************************
    ** ************** Proprieties ************************************
     * ************************************************************ */

    /**
     * @var Collection
     */
    private $STATUS_CODE;

    /**
     * @var Collection
     */
    private $CONTENT_TYPE;

    /**
     * @var Real
     */
    private $status;

    /**
     * @var Str
     */
    private $contentType;


    /* ***************************************************************
    ** ************** Constructor ************************************
     * ************************************************************ */
    public function __construct()
    {
        $this->init();
    }

    /* ***************************************************************
    ** ************** Setter *****************************************
     * ************************************************************ */

    public function setData($data):self
    {
        if ($this->data instanceof Str)
            $this->data->concat($data);
        // a cmp (templates)
        return ($this);
    }

    /* ***************************************************************
    ** ************** Getter *****************************************
     * ************************************************************ */


    /* ***************************************************************
    ** ************** Others *****************************************
     * ************************************************************ */
    private function init():self
    {
        $this->STATUS_CODE = new Collection([
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            205 => 'Reset Content',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            409 => 'Conflict',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            503 => 'Maintenance']);

        $this->CONTENT_TYPE = new Collection([
            'html' => 'text/html',
            'js' => 'application/javascript',
            'pdf' => 'application/pdf',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
            'css' => 'text/css',
            'text' => 'text/plain']);

        return ($this);
    }

    public function putData():self
    {
        if ($this->data instanceof Str)
            echo $this->data->get();
        // a cmp
        return ($this);
    }
}