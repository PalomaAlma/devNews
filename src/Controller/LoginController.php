<?php
namespace App\Controller;


use App\Model\Message;
use App\Model\User;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LoginController extends AbstractController
{

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): void
    {
        $this->twig->display('login.html.twig');
    }

    public function login()
    {
        $user = (new User($this->getDB()))->getByEmail($_POST['email']);

        if (password_verify($_POST['password'], $user->password) && $user->isValid === "1")
        {
            $_SESSION['auth'] = $user->admin;
            $_SESSION['user'] = $user->id;

            if ($this->isAdmin())
            {

                return header('Location: /admin');
            }

            return header('Location: /posts/1');
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

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function register(): void
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
            return header('Location: /thank-you');
        }
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function registerDone(): void
    {
        $this->twig->display('registerSent.html.twig');
    }

}
