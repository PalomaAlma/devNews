<?php
namespace App\Controller;

use App\Model\Post;

class PostController extends AbstractController {

    public function index() {
        $post = new Post($this->getDB());
        $posts = $post->all();

        $this->twig->display('list_posts.html.twig', [
            'posts' => $posts
        ]);
    }

}