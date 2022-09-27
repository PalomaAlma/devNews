<?php
namespace App\Controller;

use Database\DBConnection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{

    private FilesystemLoader $loader;
    protected Environment $twig;
    protected DBConnection $db;

    public function __construct(DBConnection $db)
    {
        $this->loader = new FilesystemLoader('../View');
        $this->twig = new Environment($this->loader, [
            'cache' => false,
            'debug' => true,
        ]);
        if (session_status() === PHP_SESSION_NONE)

        {
            session_start();
        }

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
        $this->db = $db;
    }

    protected function getDB(): DBConnection
    {
        return $this->db;
    }

    protected function isAdmin()
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === '1')

        {
            return true;
        } else
        {
            return header('Location: /posts/1');
        }
    }
}
