<?php

declare(strict_types=1);

namespace src\General\Controller;

use framework\Config\models\Config;
use framework\Http\models\Response;
use framework\Utilities\Controller;

class GeneralController extends Controller
{
    public function __construct(Config $config)
    {
        $this->setConfig($config);
    }

    public function loadResponse():Controller
    {
        $this->response = new Response();
        return ($this);
    }

    public function index():self
    {
        $this->loadResponse();
        $this->loadTemplate('General');
        return ($this);
    }
}
