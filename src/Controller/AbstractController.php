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
        ]);
        if (session_status() === PHP_SESSION_NONE)

        {
            session_start();
        }
        $this->twig->addGlobal('session', $_SESSION);
        $this->db = $db;
    }

    /**
     * @return DBConnection
     * get DB connection
     */
    protected function getDB(): DBConnection
    {
        return $this->db;
    }

    /**
     * @return bool
     * if user is not admin, redirect to posts views
     */
    protected function isAdmin(): bool
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === '1')

        {
            return true;
        } else
        {
            header('Location: /posts/1');
            return false;
        }
    }
}
