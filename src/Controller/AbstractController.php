<?php
namespace App\Controller;

use Database\DBConnection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController {

    private FilesystemLoader $loader;
    protected Environment $twig;
    protected $db;

    public function __construct(DBConnection $db) {
        $this->loader = new FilesystemLoader('../View');
        $this->twig = new Environment($this->loader, [
            'cache' => false,
        ]);
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
        $this->db = $db;
    }

    protected function getDB() {
        return $this->db;
    }

    protected function isAdmin() {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] === '1')
        {
//            var_dump($_SESSION['auth']); die();
            return true;
        } else {
            return header('Location: /posts');
        }
    }
}