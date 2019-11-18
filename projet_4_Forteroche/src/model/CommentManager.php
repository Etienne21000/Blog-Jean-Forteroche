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
    public function getComments($id)
    {
        $Comments = [];
        $req = $this->db->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires WHERE post_id = :post_id && report = 0 ORDER BY comment_date DESC LIMIT 0, 5');

        $req->bindValue(':post_id', $id, \PDO::PARAM_INT);

        $req->execute();

        while ($data = $req->fetch(\PDO::FETCH_ASSOC))
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

        // $req = 'SELECT commentaires.id, commentaires.user_id, commentaires.comment, commentaires.author AS author, users.pseudo AS pseudo, DATE_FORMAT(commentaires.comment_date, \'%d/%m/%Y à %Hh%i\')
        // AS comment_date FROM commentaires INNER JOIN users ON commentaires.user_id = users.id AND author = pseudo WHERE commentaires.report = 0 ORDER BY comment_date DESC';

        $req = 'SELECT c.id, c.user_id, c.comment, c.author, u.pseudo, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires AS c INNER JOIN users AS u ON c.user_id = u.id WHERE report = 0 ORDER BY comment_date DESC';

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
    Get comment by id à revoir
    dans le controller et index
    --------------------------*/
    public function getCom($id /*, $report*/)
    {
        $req = $this->db->prepare('SELECT id, post_id, author, comment,/* report*/ DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires WHERE id = :id /*&& report = :report*/');

        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        // $req->bindValue(':report', $report);

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

        $req = 'SELECT id, post_id, author, comment, report, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date
        FROM commentaires WHERE report = 1 ORDER BY comment_date DESC';

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

    // Create comment method (user)
    // public function addComment($post_id, $user_id, $comment)
    // {
    //     $req = $this->db->prepare('INSERT INTO commentaires(post_id, user_id, comment, comment_date, report)
    //     VALUES(?,?,?, NOW(), 0)');
    //     $newComment = $req->execute([
    //         $post_id,
    //         $user_id,
    //         $author,
    //         $comment
    //     ]);
    //
    //     return $newComment;
    // }


    public function addComment(Comment $comment)
    {
        $req = $this->db->prepare('INSERT INTO commentaires(post_id, user_id, author, comment, comment_date, report)
        VALUES(:post_id, :user_id, :author, :comment, NOW(), 0)');

        $req->bindValue(':post_id', $comment->post_id(), \PDO::PARAM_INT);
        $req->bindValue(':user_id', $comment->user_id(), \PDO::PARAM_INT);
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
