<?php

namespace Framework\Kernel\Application;

abstract class App
{
    protected $request = NULL;
    protected $response = NULL;
    protected $config = NULL;

    protected function setRequest(Request $request):self
    {
        $this->request = $request;
        return ($this);
    }

    public function getRequest():Request
    {
        return ($this->request);
    }

    protected function setResponse(Response $response):self
    {
        $this->response = $response;
        return ($this);
    }

    public function getResponse():Response
    {
        return ($this->response);
    }
}