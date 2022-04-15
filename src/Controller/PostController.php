<?php
namespace App\Controller;

use App\Model\Comment;
use App\Model\Post;
use App\Model\User;

class PostController extends AbstractController
{

    public function index()
    {
        $post = new Post($this->getDB());
        $posts = $post->all();

        $this->twig->display('list_posts.html.twig', [
            'posts' => $posts
        ]);
    }

    public function showPost(int $id)
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
  
    public function createComment(int $id)
    {
        $user = $_SESSION['user'];
        $post = (new Post($this->getDB()))->findById($id);
        $comment = new Comment($this->getDB());
        $result = $comment->create($_POST);
      
        if ($result)
        {
            return header('Location: /post/show/'.$id);
        }

        $this->twig->display('show_post.html.twig', [
            'post' => $post,
            'user' => $user
        ]);
    }

}
