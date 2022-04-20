<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Model\Comment;
use App\Model\Post;
use Database\DBConnection;

class PostController extends AbstractController
{

    public function create()
    {
        $post = new Post($this->getDB());

        $this->twig->display('admin/create_post.html.twig');
    }

    public function createPost()
    {
        $post = new Post($this->getDB());
        $result = $post->create($_POST);

        if ($result)
        {
            return header('Location: /admin/posts');
        }
    }

    public function listPosts(int $page)
    {
        $post = new Post($this->getDB());
        $posts = $post->all();
        $totalPosts = count($posts);
        $articlePerPage = 5;
        $nbPages = ceil($totalPosts / $articlePerPage);

        $offset = ($page - 1) * $articlePerPage;

        $posts = $post->findByPage($page, $offset);


        $this->twig->display('admin/list_posts.html.twig', [
            'posts' => $posts,
            'page' => $page,
            'nbPages' => $nbPages
        ]);
    }

    public function showPost(int $id)
    {
        $post = (new Post($this->getDB()))->findById($id);

        $this->twig->display('admin/show_post.html.twig', [
            'post' => $post
        ]);
    }

    public function edit(int $id)
    {
        $post = (new Post($this->getDB()))->findById($id);

        $this->twig->display('admin/create_post.html.twig', [
            'post' => $post
        ]);
    }

    public function update(int $id)
    {
        $post = new Post($this->getDB());
        $result = $post->update($id, $_POST);

        if ($result)
        {
            return header('Location: /admin/posts');
        }
    }

    public function delete(int $id)
    {
        $post = new Post($this->getDB());
        $result = $post->delete($id);

        if ($result)
        {
            return header('Location: /admin/posts');
        }
    }

    public function validComment(int $id)
    {
        $comment = (new Comment($this->getDB()))->findById($id);
        $result = $comment->update($id, $_POST);
        $post = $comment->post_id;

        if ($result)
        {
            return header('Location: /admin/post/show/'.$post);
        }
    }

}
