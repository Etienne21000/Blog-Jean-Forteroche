<?php
namespace controller;

use model\PostManager;
use model\CommentManager;

class Controller
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
        $Comments = $this->comments->getAllComments(/*$_GET['id']*/);

        require 'src/view/indexView.php';
    }

    // public function allCom()
    // {
    //     $Comments = $this->comments->getAllComments();
    //
    //     require 'src/view/indexView.php';
    // }

    //Affichage des chapitres sur la page dédiée
    public function post()
    {
        $Posts = $this->post->getPosts();
        require 'src/view/chapterView.php';
    }

    public function createPost()
    {
        require 'src/view/adminPost.php';
    }

    public function addPost($id, $title, $content)
    {
        $Posts = $this->post->add($title, $content);
        if($Posts === false)
        {
            throw new Exception('impossible d\'ajouter votre article');
        }
        else
        {
            header('Location: index.php?action=listComments&post=' .$this->post->id());
        }
    }

    //Get comment related to a post limit between 0 and 5 comments
    //Change name for listPosts
    public function listComments()
    {
        $post = $this->post->getOne($_GET['id']);
        $Comment = $this->comments->getComments($_GET['id']);

        require 'src/view/postView.php';
    }

    // Methode Add Comment
    public function newComment($post_id, $author, $comment)
    {
        $newComment = $this->comments->addComment($post_id, $author, $comment);

        if($newComment === false)
        {
            throw new Exception('impossible d\'ajouter votre commentaire');
        }
        else
        {
            header('Location: index.php?action=listComments&id=' . $post_id);
        }
    }

    //Update comment method
    public function updateCom($id, $comment)
    {
        $Comment = $this->comments->updateComment($id, $comment);
        // $Comment = $this->comments->getCom($id);
        if ($Comment === false)
        {
            throw new Exception("Impossible de mettre à jour le commentaire (controller)");

        }
        else
        {
            header('Location: index.php?action=listComments&id=' . $id);
        }
    }

    //Methode admin delete comment
    public function deleteCom($id)
    {
        // $post = $this->post->getOne($_GET['id']);
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            // $Comment = $this->post->getOne($_GET['id']);
            $Comment = $this->comments->deleteComment($id);
        }
        else
        {
            throw new Exception("Impossible supprimer le commentaire (controller)");
        }
        header('Location: index.php?action=listComments&id=' . $id);
        // require 'src/view/postView.php';


        // $Comment = $this->comments->deleteComment($id);
        // if($Comment === false)
        // {
        //     throw new Exception("Impossible supprimer le commentaire (controller)");
        // }
        // else
        // {
        //     header('Location: index.php?action=listComments&post=' . $id);
        // }

    }
}

// public function newComment($post_id, $author, $comment)
// {
//     $newComment = new Comment(['post_id' => $post_id, 'author' => $author, 'comment' => $comment]);
//     $this->comments->addComment($newComment);
//
//     $this->post($id);
//     // if($Comment === false)
//     // {
//     //     throw new Exception('impossible d\'ajouter votre commentaire');
//     // }
//     // else
//     // {
//     //     header('Location: index.php?action=listComments&post=' . $post_id);
//     // }
// }

// $Posts = $this->post->getOne($_GET['id']);
// if($Comment === false)
// {
//     throw new Exception('impossible de supprimer votre commentaire');
// }
// else {
// }
// public function singleComment($id)
// {
//     $this->post->getOne($_GET['post']);
//     $this->comment->getCom($_GET['id']);
// }


// public function newComment(/*$post_id, $author, $comment*/)
//     {
//         // $comment = new Comment();
//         $this->Comment->setIdpost($_POST['post_id']);
//         $this->Comment->setComment($_POST['comment']);
//         $this->Comment->setAuthor($_POST['author']);
//         // $comment->setCommentdate($_POST['comment_date']);
//         $this->comments->addComment($Comment);
//         //
//         header('Location: index.php?action=listComments&&id=' . $_POST['post-id']);
//     }

// if(!empty($_POST))
// {
//     $validation = true;
//
//     if(empty($_POST['form-pseudo']) || empty($_POST['form-comment']))
//     {
//         $validation = false;
//     }
//
//     if($_POST['form-pseudo'] > 255)
//     {
//         $validation = fasle;
//     }
//
//     if($validation)
//     {
//         $comment = new Comment([
//             'post_id' => $_GET['post_id'],
//             'author' => $_POST['form-pseudo'],
//             'comment' => $_POST['form-comment']
//         ]);

// $comment->addComment($post_id, $author, $comment);


// header('Location: index.php?action=post&id=' . $post_id);

// $Comment = $this->comments->deleteComment($comment);
// if ($Comment === false)
// {
//     throw new Exception('impossible de supprimer votre commentaire');
// }
// else
// {
//     header('Location: index.php?action=post&id=' . $id);
// }





// $postManager = new postManager();
// $Posts = $postManager->getPosts();
// $this->pm = $postManager->getPosts();
// namespace controller;
//
// // require_once 'model/manager.php';
// require_once 'model/modelChapter.php';
// require_once 'model/modelComments.php';
//
// if (isset($_GET['chapter']) && $_GET['chapter'] > 0)
// {
//     $post = getPost($_GET['chapter']);
//     // $comments = getComments($_GET['chapter']);
//
//     require('view/postView.php');
// }
// else {
//     echo "Aucun identifiant de billet ne correspond";
// }
// var_dump('chapter');


// class chapterController
// {
//     private $_chapter;
//     private $_comments;
//     private $_chapterManager;
//     private $_commentManager;
//
//     public function __construct()
//     {
//         $this->_chapterManager = new chapterManager();
//         $this->_commentManager = new commentManager();
//     }
//
//     public function chapterList()
//     {
//         $this->_chapter = $this->_chapterManager->getChapterList();
//         require 'view/indexView.php';
//         require 'view/chapterView.php';
//     }
// }
