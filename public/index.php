<?php

use Router\Router;

require '../vendor/autoload.php';

$router = new Router($_GET['url']);

$router->get('/', 'App\Controller\HomeController@index');
$router->get('/show', 'App\Controller\HomeController@show');

$router->run();