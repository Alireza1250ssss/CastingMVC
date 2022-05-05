<?php

require_once __DIR__ . "/../vendor/autoload.php";
use App\core\Application;

$app = new Application();

$app->router->get('/' , function () {

    return 'Hello World';

});


$app->router->get('/test' , function (){

    return "This is test page";
});

$app->run();