<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Model\Message;
use Database\DBConnection;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class MessageController extends AbstractController {

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function listMessages(int $page): void
    {
        $message = new Message($this->getDB());
        $totalMessages = count($message->all());
        $articlePerPage = 5;
        $nbPages = ceil($totalMessages / $articlePerPage);

        $offset = ($page - 1) * $articlePerPage;

        $messages = $message->findByPage($page, $offset);

        $this->twig->display('admin/list_messages.html.twig', [
            'messages' => $messages,
            'page' => $page,
            'nbPages' => $nbPages
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function show(int $id): void
    {
        $message = (new Message($this->getDB()))->findById($id);

        $this->twig->display('admin/show_message.html.twig', [
            'message' => $message
        ]);
    }

}
