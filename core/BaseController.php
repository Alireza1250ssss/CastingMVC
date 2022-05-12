<?php
namespace App\core;

class BaseController {
    public $request;

    public function __construct()
    {
        $this->request = Application::$request;        
    }
}