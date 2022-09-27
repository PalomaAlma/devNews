<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DashboardController extends AbstractController {

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): void
    {
        $this->isAdmin();
        $this->twig->display('admin/dashboard.html.twig');
    }
}
