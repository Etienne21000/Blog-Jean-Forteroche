<?php
namespace controller;

use model\PostManager;
use model\CommentManager;

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
        $Posts = $this->post->getPosts($start = 0, $limite = 6);

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
        // require 'src/view/chapterView.php';
    }

    public function nbPost()
    {
        $countPosts = $this->post->countPosts();

        return $countPosts;
    }

    public function addPost($id, $title, $content)
    {
        $Posts = $this->post->add($title, $content);
        if($Posts === false)
        {
            throw new Exception('impossible d\'ajouter votre article');
        }
    }

    public function getPost()
    {
        $post = $this->post->getOne($_GET['id']);

        return $post;
    }

    public function updatePost($id, $title, $content)
    {
        $Post = $this->post->update($id, $title, $content);

        if($Post === false)
        {
            throw new Exception("Impossible de mettre à jour l'article");
        }
    }

}
