<?php
/*try
{
    $bdd = new PDO('mysql:host=localhost;dbname=devnews;charset=utf8mb4', 'root', '');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}*/
require '../vendor/autoload.php';
use App\Controller\HomeController;

$loader = new \Twig\Loader\FilesystemLoader('../View');
$twig = new \Twig\Environment($loader, [
    'cache' => 'compilation_cache',
]);

$homeController = new HomeController($twig);
$homeController->index();