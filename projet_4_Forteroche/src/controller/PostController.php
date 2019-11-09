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

    //Comments by post
    // public function nbComByPost()
    // {
    //     $countByPost = $this->comments->countComByPost($_GET['post_id']);
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
    public function getCom($id)
    {
        $Comments = $this->comments->getComments($id);

        return $Comments;
    }

    //Report comment
    public function reportCom($id)
    {
        $reportedCom = $this->comments->reportComment($id);

        return $reportedCom;
    }

    //Get reported comments
    public function getReportedCom()
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
