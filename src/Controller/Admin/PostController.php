<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Model\Post;
use Database\DBConnection;

class PostController extends AbstractController
{

    function create()
    {
        $post = new Post($this->getDB());

        $this->twig->display('admin/create_post.html.twig');
    }

    function createPost()
    {
        $post = new Post($this->getDB());
        $result = $post->create($_POST);

        if ($result)
        {
            return header('Location: /admin/posts');
        }
    }

    function listPosts()
    {
        $post = new Post($this->getDB());
        $posts = $post->all();

        $this->twig->display('admin/list_posts.html.twig', [
            'posts' => $posts
        ]);
    }

    function showPost(int $id)
    {
        $post = (new Post($this->getDB()))->findById($id);

        $this->twig->display('admin/show_post.html.twig', [
            'post' => $post
        ]);
    }

    function edit(int $id)
    {
        $post = (new Post($this->getDB()))->findById($id);

        $this->twig->display('admin/create_post.html.twig', [
            'post' => $post
        ]);
    }

    function update(int $id)
    {
        $post = new Post($this->getDB());
        $result = $post->update($id, $_POST);

        if ($result)
        {
            return header('Location: /admin/posts');
        }
    }

    function delete(int $id)
    {
        $post = new Post($this->getDB());
        $result = $post->delete($id);

        if ($result)
        {
            return header('Location: /admin/posts');
        }
    }

}
