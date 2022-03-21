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
            'cache' => 'compilation_cache',
        ]);
        $this->db = $db;
    }

    protected function getDB() {
        return $this->db;
    }
}