<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Model\Message;
use Database\DBConnection;

class MessageController extends AbstractController {

    public function listMessages(int $page) {
        $message = new Message($this->getDB());
        $totalMessages = count($message->all());
        $articlePerPage = 5;
        $nbPages = ceil($totalMessages / $articlePerPage);

        $offset = ($page - 1) * $articlePerPage;

        $messages = $message->read('SELECT * FROM message LIMIT 5 OFFSET '.$offset.';');

        $this->twig->display('admin/list_messages.html.twig', [
            'messages' => $messages,
            'page' => $page,
            'nbPages' => $nbPages
        ]);
    }

    public function show(int $id) {
        $message = (new Message($this->getDB()))->findById($id);

        $this->twig->display('admin/show_message.html.twig', [
            'message' => $message
        ]);
    }

    public function delete(int $id) {
        $message = new Message($this->getDB());
        $result = $message->delete($id);

        if ($result) {
            return header('Location: /admin/message');
        }
    }

}
