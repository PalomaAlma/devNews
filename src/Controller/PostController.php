<?php
namespace App\Controller;

use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PostController extends AbstractController
{

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * show all posts
     */
    public function index(int $page): void
    {
        $post = new Post($this->getDB());
        $posts = $post->all();
        $totalPosts = count($posts);
        $articlePerPage = 5;
        $nbPages = ceil($totalPosts / $articlePerPage);

        $offset = ($page - 1) * $articlePerPage;

        $posts = $post->findByPage($page, $offset);

        $this->twig->display('list_posts.html.twig', [
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

        if (isset($_SESSION['user']))
        {
            $user = (new User($this->getDB()))->findById($_SESSION['user']);
            $this->twig->display('show_post.html.twig', [
                'post' => $post,
                'user' => $user
            ]);
        } else
        {
            $this->twig->display('show_post.html.twig', [
                'post' => $post
            ]);
        }
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * create comment in view post (if user is logged)
     */
    public function createComment(int $id): void
    {
        $user = $_SESSION['user'];
        $post = (new Post($this->getDB()))->findById($id);
        $comment = new Comment($this->getDB());
        $result = $comment->create($_POST);

        if ($result)
        {
            header('Location: /post/show/'.$id);
        }

        $this->twig->display('show_post.html.twig', [
            'post' => $post,
            'user' => $user
        ]);
    }

}
