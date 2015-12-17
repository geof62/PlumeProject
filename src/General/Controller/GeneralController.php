<?php

declare(strict_types=1);

namespace src\General\Controller;

use framework\Http\models\Response;
use framework\Utilities\Controller;

class GeneralController extends Controller
{
    public function loadResponse():self
    {
        $this->response = new Response();
        return ($this);
    }

    public function index()
    {
        $this->loadResponse();
        $this->loadTemplate('General');
    }
}
