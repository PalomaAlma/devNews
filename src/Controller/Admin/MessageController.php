<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Model\Message;
use Database\DBConnection;

class MessageController extends AbstractController {

    function listMessages() {
        $message = new Message($this->getDB());
        $messages = $message->all();

        $this->twig->display('admin/list_messages.html.twig', [
            'messages' => $messages
        ]);
    }

    function show(int $id) {
        $message = (new Message($this->getDB()))->findById($id);

        $this->twig->display('admin/show_message.html.twig', [
            'message' => $message
        ]);
    }

    function delete(int $id) {
        $message = new Message($this->getDB());
        $result = $message->delete($id);

        if ($result) {
            return header('Location: /admin/message');
        }
    }

}