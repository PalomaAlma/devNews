<?php

use Router\Router;

require '../vendor/autoload.php';


$router = new Router($_GET['url']);

$router->get('/', 'App\Controller\HomeController@index');
$router->post('/', 'App\Controller\HomeController@sendContact');
$router->get('/admin', 'App\Controller\Admin\DashboardController@index');
$router->get('/admin/message', 'App\Controller\Admin\MessageController@listMessages');
$router->get('/admin/message/:id', 'App\Controller\Admin\MessageController@show');

$router->run();