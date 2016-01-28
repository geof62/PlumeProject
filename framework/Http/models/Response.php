<?php

declare(strict_types=1);

namespace framework\Http\models;

use framework\Exception\models\Exception;
use framework\Template\models\Template;

class Response
{
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

    protected $code;
    protected $content;
    protected $contentType = 'text/html';

    public function __construct(Template $tmp, int $code = 200)
    {
        $this->setCode($code);
        $this->setTemplate($tmp);
        $this->setContentType($tmp->getType());
    }

    public function setCode($code):self
    {
        if (array_key_exists($code, self::STATUS_CODE))
            $this->code = $code;
        else
            throw new Exception("Invalid status code");
        return ($this);
    }

    public function setTemplate(Template $template):self
    {
        $this->content = $template;
        return ($this);
    }

    public function setContentType(string $type):self
    {
        if (!array_key_exists($type, self::CONTENT_TYPE))
            throw new Exception("Invalid content type : " . $type);
        $this->contentType = self::CONTENT_TYPE[$type];
        return ($this);
    }

    public function getTemplate():Template
    {
        return ($this->content);
    }

    public function send():self
    {
        header('Content-Type: ' . $this->contentType, true, $this->code);
        $this->content->put();
        return ($this);
    }
}