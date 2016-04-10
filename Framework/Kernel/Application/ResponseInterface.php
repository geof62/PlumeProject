<?php

namespace Framework\Kernel\Application;

interface ResponseInterface
{
    public function setData($data);

    public function putData();
}