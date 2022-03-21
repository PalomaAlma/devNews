<?php
namespace App\Controller;


use App\Model\Message;

class HomeController extends AbstractController {

    public function index() {
        $this->twig->display('home.html.twig');
    }

    public function sendContact() {
        $message = new Message($this->getDB());
        $result = $message->create($_POST);
//        var_dump($result);
        if ($result) {
            return header('Location: /');
        }

        $this->twig->display('home.html.twig');
    }

}