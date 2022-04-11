<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;

class DashboardController extends AbstractController {

    public function index() {
        $this->isAdmin();
        $this->twig->display('admin/dashboard.html.twig');
    }
}