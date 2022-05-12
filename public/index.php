<?php

use Router\Router;

require '../vendor/autoload.php';


$router = new Router($_GET['url']);

$router->get('/', 'App\Controller\HomeController@index');
$router->post('/', 'App\Controller\HomeController@sendContact');
$router->get('/sent', 'App\Controller\HomeController@messageSent');
$router->get('/login', 'App\Controller\LoginController@index');
$router->post('/login', 'App\Controller\LoginController@login');
$router->get('/logout', 'App\Controller\LoginController@logout');
$router->get('/register', 'App\Controller\LoginController@register');
$router->post('/register', 'App\Controller\LoginController@registerPost');
$router->get('/admin', 'App\Controller\Admin\DashboardController@index');
$router->get('/admin/posts/:page', 'App\Controller\Admin\PostController@listPosts');
$router->get('/admin/users', 'App\Controller\Admin\UserController@listUsers');
$router->post('/admin/users/:id', 'App\Controller\Admin\UserController@validUser');
$router->post('/admin/user/delete/:id', 'App\Controller\Admin\UserController@delete');
$router->get('/admin/post/create', 'App\Controller\Admin\PostController@create');
$router->post('/admin/post/create', 'App\Controller\Admin\PostController@createPost');
$router->get('/admin/post/show/:id', 'App\Controller\Admin\PostController@showPost');
$router->post('/admin/post/delete/:id', 'App\Controller\Admin\PostController@delete');
$router->get('/admin/post/edit/:id', 'App\Controller\Admin\PostController@edit');
$router->post('/admin/post/edit/:id', 'App\Controller\Admin\PostController@update');
$router->post('/admin/comment/valid/:id', 'App\Controller\Admin\PostController@validComment');
$router->get('/admin/messages/:page', 'App\Controller\Admin\MessageController@listMessages');
$router->get('/admin/message/:id', 'App\Controller\Admin\MessageController@show');

$router->get('/posts/:page', 'App\Controller\PostController@index');
$router->get('/post/show/:id', 'App\Controller\PostController@showPost');
$router->post('/post/show/:id', 'App\Controller\PostController@createComment');

$router->run();