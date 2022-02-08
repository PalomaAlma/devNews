<?php
require '../vendor/autoload.php';
use App\Controller\HomeController;

$loader = new \Twig\Loader\FilesystemLoader('../View');
$twig = new \Twig\Environment($loader, [
    'cache' => 'compilation_cache',
]);
