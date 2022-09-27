<?php
namespace App\Controller;


use App\Model\Message;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController extends AbstractController{

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function index(): void
    {
        $this->twig->display('home.html.twig');
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function sendContact()
    {
        $message = new Message($this->getDB());
        $result = $message->create($_POST);

        if ($result)
        {
            return header('Location: /sent');
        }

        $this->twig->display('home.html.twig');
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function messageSent(): void
    {
        $this->twig->display('messageSent.html.twig');
    }

}
