<?php

use Router\Router;

require '../vendor/autoload.php';


$router = new Router($_GET['url']);

$router->get('/', 'App\Controller\HomeController@index');
$router->post('/', 'App\Controller\HomeController@sendContact');

$router->run();