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
     * login form
     */
    public function index(): void
    {
        $this->twig->display('login.html.twig');
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * login function
     */
    public function login():void
    {
        $user = (new User($this->getDB()))->getByEmail($_POST['email']);

        if (password_verify($_POST['password'], $user->password) && $user->isValid === "1")
        {
            $_SESSION['auth'] = $user->admin;
            $_SESSION['user'] = $user->id;

            if ($this->isAdmin())
            {

                header('Location: /admin');
            }

            header('Location: /posts/1');
        } else {

            header('Location: /login');
        }

        $this->twig->display('home.html.twig');
    }

    /**
     * @return void
     * logout function
     */
    public function logout(): void
    {
        session_destroy();

        header('Location: /login');
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * register form
     */
    public function register(): void
    {
        $this->twig->display('register.html.twig');
    }

    /**
     * @return void
     * register in DB
     */
    public function registerPost(): void
    {
        $user = new User($this->getDB());
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $result = $user->create($_POST);

        if ($result)
        {
            header('Location: /thank-you');
        }
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * confirmation after register
     */
    public function registerDone(): void
    {
        $this->twig->display('registerSent.html.twig');
    }

}
