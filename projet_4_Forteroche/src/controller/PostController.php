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

    //Affichage des chapitres sur la page d'accueil
    public function listPosts()
    {
        $Posts = $this->post->getPosts($start = 0, $limite = 2);

        return $Posts;
    }

    //Affichage des posts sur la page admin
    public function adminPost()
    {
        $Posts = $this->post->getPosts($start = 0, $limite = 3);

        return $Posts;
    }

    //Affichage des chapitres sur la page dédiée
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

    public function addPost()
    {
        $post = new Post([$data]);

        $post->setTitle(htmlspecialchars($_POST['title']));
        $post->setContent(htmlspecialchars($_POST['content']));

        $this->post->add($post);
    }

    public function deletePost($id)
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $Posts = $this->post->delete($id);
        }
        else
        {
            throw new \Exception("Impossible de supprimer l'article (controller)");
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
}
