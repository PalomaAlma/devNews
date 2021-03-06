<?php
namespace App\Controller;


use App\Model\Message;

class HomeController extends AbstractController{

    public function index(){
        $this->twig->display('home.html.twig');
    }

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

    public function messageSent()
    {
        $this->twig->display('messageSent.html.twig');
    }

}
