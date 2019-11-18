<?php
namespace controller;

use model\CommentManager;
use model\Comment;

class CommentController
{
    private $post;
    private $comments;

    public function __construct()
    {
        $this->comments = new CommentManager();
    }

    public function lastCom()
    {
        $Comments = $this->comments->getAllComments($start = 0, $limite = 3);

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

    //Comments by post
    // public function nbComByPost()
    // {
    //     $countByPost = $this->comments->countComByPost($_GET['post_id']);
    // }

    // Methode Add Comment
    public function newComment(/*$post_id, $user_id, $author, $comment*/)
    {
        $comment = new Comment([$data]);

        // $Comment->setIdpost($_POST['post_id']);
        // $Comment->setUserId($_POST['user_id']);
        // $Comment->setAuthor($_POST['author']);
        // $Comment->setComment(htmlspecialchars($_POST['comment']));

        $comment->setIdpost($_POST['post_id']);
        $comment->setUserId($_POST['user_id']);
        $comment->setAuthor($_POST['author']);
        $comment->setComment($_POST['comment']);

        $this->comments->addComment($comment);

    }

    // public function newComment()
    // {
    //     $comment = new Comment([
    //
    //     'post_id' => ($_GET['post_id']),
    //     'author' => ($_POST['author']),
    //     'comment' => ($_POST['comment'])
    // ]);
    //
    //     // $comment->setIdpost($_GET['post_id']);
    //     // $comment->setAuthor($_POST['author']);
    //     // $comment->setComment($_POST['comment']);
    //
    //     $this->comments->addComment($comment);
    //
    //     // if($newComment === false)
    //     // {
    //     //     throw new Exception('impossible d\'ajouter votre commentaire');
    //     // }
    // }

    //Update comment method
    public function updateCom($id, $comment)
    {
        $Comment = new Comment([$data]);

        $Comment->setId($id);
        $Comment->setComment($comment);

        $this->comments->updateComment($Comment);
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
    public function getCom($id)
    {
        $Comments = $this->comments->getComments($id);

        return $Comments;
    }

    //Get one comment by id
    public function getOne($id /*, $report*/)
    {
    $Comment = $this->comments->getCom($id /*, $report*/);

        return $Comment;
    }

    //Report comment
    public function reportCom($id)
    {
        $reportedCom = $this->comments->reportComment($id);

        return $reportedCom;
    }

    //Validate reported comment
    public function validCom($id)
    {
        $validCom = $this->comments->validateCom($id);
    }

    //Get reported comments
    public function getReportedCom()
    {
        $report = $this->comments->getReportedComments($start = 0, $limite = 3);

        return $report;
    }

    //Get all reported Comments
    public function getAllReported()
    {
        $report = $this->comments->getReportedComments();

        return $report;
    }

    //Count reported Comments
    public function nbReported()
    {
        $countReport = $this->comments->countReported();

        return $countReport;
    }

}
