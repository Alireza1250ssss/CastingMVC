<?php
// echo "<pre>";var_dump($_SERVER); die;
require_once __DIR__ . "/../vendor/autoload.php";
// define("ROOT", $_SERVER['DOCUMENT_ROOT']);

use App\app\Controllers\CourseController;
use App\core\Application;
use App\app\renderView;
use App\app\Controllers\HomeController;
use App\app\Controllers\TodoController;

$app = new Application(__DIR__);

$app->router->get('/home', [HomeController::class, 'index']);
$app->router->get('/', [HomeController::class, 'index']);

$app->router->get('/GetAll', [TodoController::class, 'GetAll']);
$app->router->get('/GetByID', [TodoController::class, 'GetByID']);
$app->router->post('/GetByID' , [TodoController::class , 'GetByID_Post']);
$app->router->get('/AddTODO', [TodoController::class, 'AddTODO']);
$app->router->post('/SendForm', [TodoController::class, 'SendForm']);
$app->router->post('/Toggle', [TodoController::class, 'Toggle']);
$app->router->get('/Mohammad', [TodoController::class, 'mohammad']);
$app->router->get('/courses', [CourseController::class, 'index']);
$app->router->post('/add-courses', [CourseController::class, 'addCourse']);
$app->router->post('/get-courses', [CourseController::class, 'getCourses']);

/*  $app->router->get('/contact', 'contact');
 $app->router->get('/home', 'home');
 $app->router->get('/slm', 'slm');
 $app->router->get('/dalam', 'dalam');
 */




$app->run();
