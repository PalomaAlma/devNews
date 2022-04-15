<?php
namespace App\Controller;


use App\Model\Message;
use App\Model\User;

class LoginController extends AbstractController
{

    public function index()
    {
        $this->twig->display('login.html.twig');
    }

    public function login()
    {
        $user = (new User($this->getDB()))->getByEmail($_POST['email']);

        if (password_verify($_POST['password'], $user->password))
        {
            $_SESSION['auth'] = $user->admin;
            $_SESSION['user'] = $user->id;
//            var_dump($_SESSION['user']); die();

            if ($this->isAdmin())
            {

                return header('Location: /admin');
            }

            return header('Location: /posts');
        } else {

            return header('Location: /login');
        }

        $this->twig->display('home.html.twig');
    }

    public function logout()
    {
        session_destroy();

        return header('Location: /login');
    }

    public function register()
    {
        $this->twig->display('register.html.twig');
    }

    public function registerPost()
    {
        $user = new User($this->getDB());
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $result = $user->create($_POST);

        if ($result)
        {
            return header('Location: /register');
        }
    }

}
