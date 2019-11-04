<?php
namespace controller;

// use model\PostManager;
use model\CommentManager;
use model\Comment;

class CommentController
{
    private $post;
    private $comments;

    public function __construct()
    {
        // $this->post = new PostManager();
        $this->comments = new CommentManager();
    }

    public function lastCom()
    {
        $Comments = $this->comments->getLastComments();

        return $Comments;
    }

    public function allCom()
    {
        $Comments = $this->comments->getAllComments();

        return $Comments;
    }

    public function nbCom()
    {
        $countComs = $this->comments->countComments();

        return $countComs;
    }

    //Count method by post id
    // public function nbComById()
    // {
    //     $countId = $this->comments->countComId();
    //
    //     return $countId;
    // }

    // Methode Add Comment
    public function newComment($post_id, $author, $comment)
    {
        $newComment = $this->comments->addComment($post_id, $author, $comment);

        if($newComment === false)
        {
            throw new Exception('impossible d\'ajouter votre commentaire');
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

        // return $Comment;
    }

    //Methode admin delete comment
    public function deleteCom($id)
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $Comment = $this->comments->deleteComment($id);
        }
        else
        {
            throw new Exception("Impossible supprimer le commentaire (controller)");
        }
    }

    //Get comment by post
    public function getCom()
    {
        $Comment = $this->comments->getComments($_GET['id']);

        return $Comment;
    }

}

// public function newComment(/*$post_id, $author, $comment*/)
//     {
//         $newComment = new Comment([
//             'post_id' => $_GET['post_id'],
//             'author' => $_POST['form-pseudo'],
//             'comment' => $_POST['form-comment']
//         ]);
//         $this->comments->addComment($comment);
//
//     }
