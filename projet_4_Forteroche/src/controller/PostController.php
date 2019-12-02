<?php
namespace controller;

use model\PostManager;
use model\CommentManager;
use model\Post;

class PostController
{
    private $post;
    private $comments;

    public function __construct()
    {
        $this->post = new PostManager();
        $this->comments = new CommentManager();
    }

    public function listPosts()
    {
        $Posts = $this->post->getPosts($start = 0, $limite = 2);

        return $Posts;
    }

    public function adminPost()
    {
        $Posts = $this->post->getPosts($start = 0, $limite = 3);

        return $Posts;
    }

    public function post()
    {
        $Posts = $this->post->getPosts();

        return $Posts;
    }

    public function nbPost()
    {
        $countPosts = $this->post->countPosts();

        return $countPosts;
    }

    public function addPost($title, $content)
    {
        $post = new Post([$data]);

        $post->setTitle($title);
        $post->setContent($content);

        $this->post->add($post);
    }

    public function deletePost($id)
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $Posts = $this->post->delete($id);
        }
    }

    public function getPost($id)
    {
        $post = $this->post->getOne($id);

        return $post;
    }

    public function updatePost($id, $title, $content)
    {
        $Post = new Post([$data]);

        $Post->setId($id);
        $Post->setTitle($title);
        $Post->setContent($content);

        $this->post->update($Post);
    }

    public function errors()
    {
        require 'src/view/front_end/errorView.php';
    }
}
