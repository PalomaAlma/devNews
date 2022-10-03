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
     * home view
     */
    public function index(): void
    {
        $this->twig->display('home.html.twig');
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * send message from contact form
     */
    public function sendContact(): void
    {
        $message = new Message($this->getDB());
        $result = $message->create($_POST);

        if ($result)
        {
            header('Location: /sent');
        }

        $this->twig->display('home.html.twig');
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * confirmation after sent message from contact form
     */
    public function messageSent(): void
    {
        $this->twig->display('messageSent.html.twig');
    }

}
