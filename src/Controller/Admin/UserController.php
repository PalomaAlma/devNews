<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Model\User;
use Database\DBConnection;

class UserController extends AbstractController
{

    function listUsers()
    {
        $user = new User($this->getDB());
        $users = $user->all();

        $this->twig->display('admin/list_users.html.twig', [
            'users' => $users
        ]);
    }

    function showUser(int $id)
    {
        $user = (new User($this->getDB()))->findById($id);

        $this->twig->display('admin/show_user.html.twig', [
            'user' => $user
        ]);
    }

    function validUser(int $id)
    {
        $user = (new User($this->getDB()))->findById($id);
        $result = $user->update($id, $_POST);

        $this->twig->display('admin/list_user.html.twig', [
            'user' => $user
        ]);
    }

    function delete(int $id)
    {
        $user = new User($this->getDB());
        $result = $user->delete($id);

        if ($result)
        {
            return header('Location: /admin/users');
        }
    }
}
