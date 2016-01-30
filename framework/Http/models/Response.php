<?php

declare(strict_types=1);

namespace framework\Http\models;

use framework\Exception\models\Exception;
use framework\Template\models\Template;

/**
 * Class Response.
 * Manage the http response
 *
 * @package framework\Http\models
 */
class Response
{
    /**
     * supported http status code
     * @var array
     */
    const STATUS_CODE = [
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
        503 => 'Maintenance'
    ];

    /**
     * supported content types
     * @var array
     */
    const CONTENT_TYPE = [
        'html' => 'text/html',
        'js' => 'application/javascript',
        'pdf' => 'application/pdf',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'jpeg' => 'image/jpeg',
        'css' => 'text/css',
        'text' => 'text/plain',
    ];

    /**
     * the status code
     * @var int
     */
    protected $code;

    /**
     * template of response
     * @var string
     */
    protected $content;

    /**
     * the content type
     * @var string
     */
    protected $contentType = 'text/html';

    /**
     * Response constructor.
     * @param Template $tmp
     * @param int $code
     */
    public function __construct(Template $tmp, int $code = 200)
    {
        $this->setCode($code);
        $this->setTemplate($tmp);
        $this->setContentType($tmp->getType());
    }

    /**
     * set the code status
     * @param int $code
     * @return Response
     * @throws Exception
     */
    public function setCode(int $code):self
    {
        if (array_key_exists($code, self::STATUS_CODE))
            $this->code = $code;
        else
            throw new Exception("Invalid status code");
        return ($this);
    }

    /**
     * set the Template
     * @param Template $template
     * @return Response
     */
    public function setTemplate(Template $template):self
    {
        $this->content = $template;
        return ($this);
    }

    /**
     * @param string $type
     * @return Response
     * @throws Exception
     */
    public function setContentType(string $type):self
    {
        if (!array_key_exists($type, self::CONTENT_TYPE))
            throw new Exception("Invalid content type : " . $type);
        $this->contentType = self::CONTENT_TYPE[$type];
        return ($this);
    }

    /**
     * @return Template
     */
    public function getTemplate():Template
    {
        return ($this->content);
    }

    /**
     * send the response to the client
     * @return Response
     */
    public function send():self
    {
        header('Content-Type: ' . $this->contentType, true, $this->code);
        $this->content->put();
        return ($this);
    }
}