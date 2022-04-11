<?php
namespace App\Controller;


use App\Model\Message;
use App\Model\User;

class LoginController extends AbstractController {

    public function index() {
        $this->twig->display('login.html.twig');
    }

    public function login() {
        $user = (new User($this->getDB()))->getByEmail($_POST['email']);
//        var_dump($user->password);
        if (password_verify($_POST['password'], $user->password)) {
//            var_dump($user); die();
            $_SESSION['auth'] = $user->admin;
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

    public function logout() {
        session_destroy();

        return header('Location: /login');
    }

    function register() {
        $this->twig->display('register.html.twig');
    }

    function registerPost() {
        $user = new User($this->getDB());
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
//        var_dump($_POST); die();
        $result = $user->create($_POST);
//        var_dump($result);

        if ($result) {
            return header('Location: /register');
        }
    }

}