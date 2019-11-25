<?php
namespace controller;

use model\CommentManager;
use model\Comment;

class CommentController
{
    // private $post;
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

    //count com by user id
    public function countComUser()
    {
        
    }

    // Methode Add Comment
    public function newComment($post_id, $user_id, $comment)
    {
        $Comment = new Comment([$data]);

        $Comment->setIdpost($post_id);
        $Comment->setUserId($user_id);
        $Comment->setComment($comment);

        $this->comments->addComment($Comment);
    }

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
        $Comments = $this->comments->getComments($id, $start = 0, $limite = 5);

        return $Comments;
    }

    //Get comment by post Admin
    public function getComAdmin($id)
    {
        $Comments = $this->comments->getComments($id);

        return $Comments;
    }

    //Get one comment by id
    public function getOne($id)
    {
    $Comment = $this->comments->getCom($id);

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
