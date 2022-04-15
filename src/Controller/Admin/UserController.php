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


    function validUser(int $id)
    {
        $user = (new User($this->getDB()))->findById($id);
        $result = $user->update($id, $_POST);

        if ($result)
        {
            return header('Location: /admin/users');
        }
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
