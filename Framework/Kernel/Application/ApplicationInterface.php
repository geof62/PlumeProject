<?php

namespace Framework\Kernel\Application;

interface ApplicationInterface
{
    public function initRequest(Request $req);

    public function initResponse(Response $res);
}