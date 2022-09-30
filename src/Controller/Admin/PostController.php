<?php

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Model\Comment;
use App\Model\Post;
use Database\DBConnection;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PostController extends AbstractController
{

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * create post form
     */
    public function create(): void
    {
        $post = new Post($this->getDB());

        $this->twig->display('admin/create_post.html.twig');
    }

    /**
     * @return void
     * create post in DB
     */
    public function createPost(): void
    {
        $post = new Post($this->getDB());
        $result = $post->create($_POST);

        if ($result)
        {
            header('Location: /admin/posts/1');
        }
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * read all posts
     */
    public function listPosts(int $page): void
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

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * show one post
     */
    public function showPost(int $id): void
    {
        $post = (new Post($this->getDB()))->findById($id);

        $this->twig->display('admin/show_post.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * edit post form
     */
    public function edit(int $id):void
    {
        $post = (new Post($this->getDB()))->findById($id);

        $this->twig->display('admin/create_post.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @param int $id
     * @return void
     * edit post in DB
     */
    public function update(int $id): void
    {
        $post = new Post($this->getDB());
        $result = $post->update($id, $_POST);

        if ($result)
        {
            header('Location: /admin/posts/1');
        }
    }

    /**
     * @param int $id
     * @return void
     * delete post
     */
    public function delete(int $id): void
    {
        $post = new Post($this->getDB());
        $result = $post->delete($id);

        if ($result)
        {
            header('Location: /admin/posts/1');
        }
    }

    /**
     * @param int $id
     * @return void
     * valid comment to show in post view
     */
    public function validComment(int $id): void
    {
        $comment = (new Comment($this->getDB()))->findById($id);
        $result = $comment->update($id, $_POST);
        $post = $comment->post_id;

        if ($result)
        {
            header('Location: /admin/post/show/'.$post);
        }
    }

}
