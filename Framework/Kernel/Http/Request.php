<?php

namespace Framework\Kernel\Http;

use Framework\Kernel\Exceptions\Exception;
use Framework\Kernel\Types\Collection;
use Framework\Kernel\Types\Str;
use Framework\Kernel\Types\Type;
use Framework\Kernel\Types\TypeException;

final class Request extends \Framework\Kernel\Application\Request
{
    /**
     * @var Collection
     */
    private $ALLOW_METHODS;

    /**
     * @var Collection
     */
    protected $data_get;

    /**
     * @var Collection
     */
    protected $data_post;

    /**
     * @var Collection
     */
    protected $data_file;

    /**
     * @var Collection
     */
    protected $data;

    /**
     * @var Str
     */
    protected $uri;

    /**
     * @var Str
     */
    protected $method;

    /**
     * if $no_inputs is true, the constructor doesn't put data from globals
     * Request constructor.
     * @param bool $no_inputs
     */
    public function __construct($no_inputs = false)
    {
        $this->ALLOW_METHODS = new Collection(['GET', 'PUT', 'DEL', 'POST']);
        if ($no_inputs === false)
        {
            $this->setParameters($_SERVER);
            $this->setDataGet($_GET);
            $this->setDataFile($_FILES);
            $this->setDataPost($_POST);
            $this->setDataFile(file_get_contents('php://input'));
        }
    }

    /**
     * @param Collection|array $params
     * @return Request
     */
    public function setParameters($params):self
    {
        if (!($params instanceof Collection))
            $params = new Collection($params);
        $this->setServer($params);
        return ($this);
    }

    /**
     * @param Collection $server
     * @return Request
     * @throws Exception
     */
    private function setServer(Collection $server):self
    {
        if (!$server->keyExists('HTTP_METHOD'))
            throw new Exception("no method precised for the request");
        $this->setMethod($server['HTTP_METHOD']);

        if (!$server->keyExists('REQUEST_URI'))
            throw new Exception("no uri precised for the request");
        $this->setUri($server['REQUEST_URI']);

        return ($this);
    }

    /**
     * @param Collection|array $get
     * @return Request
     */
    public function setDataGet($get):self
    {
        if (!($get instanceof Collection))
            $get = new Collection($get);
        $this->data_get = $get;
        return ($this);
    }

    /**
     * @param Collection|array $post
     * @return Request
     */
    public function setDataPost($post):self
    {
        if (!($post instanceof Collection))
            $post = new Collection($post);
        $this->data_post = $post;
        return ($this);
    }

    /**
     * @param Collection|array $data
     * @return Request
     */
    public function setData($data):self
    {
        if (!($data instanceof Collection))
            $data = new Collection($data);
        $this->data = $data;
        return ($this);
    }

    /**
     * @param Collection|array $file
     * @return Request
     */
    public function setDataFile($file):self
    {
        if (!($file instanceof Collection))
            $file = new Collection($file);
        $this->data_file = $file;
        return ($this);
    }

    /**
     * @param Str|string $uri
     * @return Request
     */
    public function setUri($uri):self
    {
        if (!($uri instanceof Str))
            $uri = new Str($uri);
        $this->uri = $uri;
        return ($this);
    }

    /**
     * @param Str|string $method
     * @return Request
     * @throws Exception
     */
    public function setMethod($method):self
    {
        if (!($method instanceof Str))
            $method = new Str($method);
        if (!$this->ALLOW_METHODS->inArray($method))
            throw new Exception("invalid method : " . $method->get());
        $this->method = $method;
        return ($this);
    }


    /**
     * Init a new Request.
     * Use it for units tests
     * @param Collection|array $server
     * @param Collection|array $get
     * @param Collection|array $post
     * @param Collection|array $data
     * @param Collection|array $file
     * @return Request
     */
    public static function create($server, $get, $post = [], $data = [], $file = []):self
    {
        $req = new self();
        $req->setParameters($server)
            ->setDataGet($get)
            ->setDataPost($post)
            ->setData($data)
            ->setDataFile($file);
        return ($req);
    }
}