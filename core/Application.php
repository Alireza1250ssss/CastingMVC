<?php

namespace App\core;


use App\core\Router;
use App\core\Request;
use App\core\Response;
class Application{
    public static  $ROOT;
    public  $router;
    public static $request;
    public  $response;
    public static $app;

    public function __construct($root)
    {
        self::$ROOT = $root;
        self::$request = Request::getInstance();
        $this->router = new Router(self::$request);
        $this->response = Response::getInstance();
        self::$app=$this;
    }

    public function run(){
       
        $this->router->resolve(); 
    }
}