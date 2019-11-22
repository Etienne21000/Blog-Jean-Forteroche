<?php

namespace model;
use model\Comment;

class CommentManager extends Manager
{
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    //Get list of comment by post id
    // public function getComments($id)
    // {
    //     $Comments = [];
    //
    //     $req = $this->db->prepare('SELECT c.id, c.post_id, u.pseudo, c.comment, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%i\')
    //     AS comment_date FROM commentaires AS c LEFT JOIN users AS u ON c.user_id = u.id
    //     WHERE c.post_id = :post_id AND c.report = 0 ORDER BY comment_date DESC LIMIT 0, 5');
    //
    //     $req->bindValue(':post_id', $id, \PDO::PARAM_INT);
    //
    //     $req->execute();
    //
    //     while ($data = $req->fetch(\PDO::FETCH_ASSOC))
    //     {
    //         $comment = new Comment($data);
    //         $Comments[] = $comment;
    //     }
    //     return $Comments;
    // }

    public function getComments($id, $start =-1, $limite = -1)
    {
        $Comments = [];

        $req = 'SELECT c.id, c.post_id, u.pseudo, c.comment, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires AS c LEFT JOIN users AS u ON c.user_id = u.id
        WHERE c.post_id = :post_id AND c.report = 0 ORDER BY comment_date DESC';

        if ($start != -1 || $limite != -1)
        {
            $req .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $start;
        }

        $result = $this->db->prepare($req);

        $result->bindValue(':post_id', $id, \PDO::PARAM_INT);

        $result->execute();

        while ($data = $result->fetch(\PDO::FETCH_ASSOC))
        {
            $comment = new Comment($data);
            $Comments[] = $comment;
        }
        return $Comments;
    }

    /*------------------------------
    list comments
    with limit variables
    -------------------------------*/
    public function getAllComments($start =-1, $limite = -1)
    {
        $Comments = [];

        $req = 'SELECT c.id, c.comment, u.pseudo, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires AS c LEFT JOIN users AS u ON c.user_id = u.id  WHERE c.report = 0 ORDER BY comment_date DESC';

        if ($start != -1 || $limite != -1)
        {
            $req .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $start;
        }

        $result = $this->db->query($req);

        while ($data = $result->fetch(\PDO::FETCH_ASSOC))
        {
            $comment = new Comment($data);
            $Comments[] = $comment;
        }
        return $Comments;
    }

    /*-------------------------
    Get comment by id
    --------------------------*/
    public function getCom($id)
    {
        $req = $this->db->prepare('SELECT c.id, c.comment, u.pseudo,
        DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires AS c LEFT JOIN users AS u ON c.user_id = u.id
        WHERE c.id = :id');

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);
        $Comment = new Comment($data);

        return $Comment;
    }

    //Count total of comments
    public function countComments()
    {
        $countComs = $this->db->query('SELECT COUNT(*) FROM commentaires WHERE report = 0')->fetchColumn();

        return $countComs;
    }

    //Count reported comments
    public function countReported()
    {
        $countReport = $this->db->query('SELECT COUNT(*) FROM commentaires WHERE report = 1')->fetchColumn();

        return $countReport;
    }

    //Get all reported comments
    public function reportComment($id)
    {
        $req = $this->db->prepare('UPDATE commentaires SET report = 1 WHERE id = :id');

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();
    }

    //Validate a reported comment
    public function validateCom($id)
    {
        $req = $this->db->prepare('UPDATE commentaires SET report = 0 WHERE id = :id');

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();
    }

    /*------------------------------
    list reported comments
    with limit variables
    -------------------------------*/
    public function getReportedComments($start = -1, $limite = -1)
    {
        $report = [];

        $req = 'SELECT c.id, u.pseudo, c.comment, c.report, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date
        FROM commentaires AS c LEFT JOIN users AS u ON c.user_id = u.id WHERE c.report = 1 ORDER BY comment_date DESC';

        if ($start != -1 || $limite != -1)
        {
            $req .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $start;
        }

        $result = $this->db->query($req);

        while ($data = $result->fetch(\PDO::FETCH_ASSOC))
        {
            $com = new Comment($data);
            $report[] = $com;
        }

        return $report;
    }

    public function addComment(Comment $comment)
    {
        $req = $this->db->prepare('INSERT INTO commentaires(post_id,/* user_id,*/ author, comment, comment_date, report)
        VALUES(:post_id, /*:user_id,*/ :author, :comment, NOW(), 0)');

        $req->bindValue(':post_id', $comment->post_id(), \PDO::PARAM_INT);
        // $req->bindValue(':user_id', $comment->user_id(), \PDO::PARAM_INT);
        $req->bindValue(':author', $comment->author());
        $req->bindValue(':comment', $comment->comment());

        $req->execute();
    }

    //Delet comment (admin session)
    public function deleteComment($id)
    {
        $req = $this->db->prepare('DELETE FROM commentaires WHERE id = :id');

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();
    }

    //Update comment method
    public function updateComment(Comment $comment)
    {
        $req = $this->db->prepare('UPDATE commentaires SET comment = :comment, report = 0, edition_com_date = NOW()
        WHERE id = :id');

        $req->bindValue(':comment', $comment->comment());
        $req->bindValue(':id', $comment->id(), \PDO::PARAM_INT);

        $req->execute();
    }
}
