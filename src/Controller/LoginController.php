<?php
namespace App\Controller;


use App\Model\Message;
use App\Model\User;

class LoginController extends AbstractController {

    public function index() {
        $this->twig->display('login.html.twig');
    }

    public function login() {
        $user = (new User($this->getDB()))->getByEmail('palomavacheron@gmail.com');
        var_dump($user->password);
        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['auth'] = $user->admin;
            if ($user->admin === 1) {
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

}