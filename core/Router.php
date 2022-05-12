<?php

namespace App\core;

use App\Core\Request;
use App\core\Application;
class Router
{
    public $routes = [];
    public  $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function get($path, $callback)
    {


        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }


    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();


        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            (Application::$app)->response->setStatusCode(404);
            //todo set page 404 for view
            die("Not found");
        }
        if (is_array($callback)) {
            $callback[0] = new $callback[0];
        }
        call_user_func($callback);
    }

}