<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Model\User;
use Database\DBConnection;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserController extends AbstractController
{

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function listUsers(): void
    {
        $user = new User($this->getDB());
        $users = $user->all();

        $this->twig->display('admin/list_users.html.twig', [
            'users' => $users
        ]);
    }


    public function validUser(int $id)
    {
        $user = (new User($this->getDB()))->findById($id);
        $result = $user->update($id, $_POST);

        if ($result)
        {
            return header('Location: /admin/users');
        }
    }

    public function delete(int $id)
    {
        $user = new User($this->getDB());
        $result = $user->delete($id);

        if ($result)
        {
            return header('Location: /admin/users');
        }
    }
}
