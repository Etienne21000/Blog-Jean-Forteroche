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
        $Posts = $this->post->getPosts();

        return $Posts;
    }

    //Affichage des chapitres sur la page dédiée
    public function post()
    {
        $Posts = $this->post->allPosts();

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


// $Comments = $this->comments->getLastComments(/*$_GET['id']*/);
// require 'src/view/indexView.php';

// public function createPost()
// {
//     require 'src/view/adminPost.php';
// }

//Change name for listPosts
// public function listComments()
// {
//     $post = $this->post->getOne($_GET['id']);
//     $Comment = $this->comments->getComments($_GET['id']);
//
//     require 'src/view/postView.php';
// }
