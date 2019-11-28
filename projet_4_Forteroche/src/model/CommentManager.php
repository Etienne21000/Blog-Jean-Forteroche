<?php

namespace model;
use model\Comment;

class CommentManager extends Manager
{
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

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

    //Get comments by user id
    public function getCommentsByUser($user_id, $report=-1, $start =-1, $limite = -1)
    {
        $Comments = [];

        $req = 'SELECT c.id, c.user_id, u.pseudo, c.comment, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires AS c LEFT JOIN users AS u ON c.user_id = u.id';

        if ($start != -1 || $limite != -1)
        {
            $req .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $start;
        }

        if($report!=-1)
        {
            $req .= ' WHERE c.user_id = :user_id AND c.report = ' . (int) $report;
        }

        $result = $this->db->prepare($req);

        $result->bindValue(':user_id', $user_id, \PDO::PARAM_INT);

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
    public function getAllComments($report = -1, $start =-1, $limite = -1)
    {
        $Comments = [];

        $req = 'SELECT c.id, c.comment, u.pseudo, c.user_id, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires AS c LEFT JOIN users AS u ON c.user_id = u.id ';

        if($report != -1)
        {
            $req.= ' WHERE c.report = ' . (int) $report . ' ORDER BY comment_date DESC';
        }

        if ($start != -1 || $limite != -1)
        {
            $req .= ' LIMIT '.(int) $limite . ' OFFSET ' . (int) $start;
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
        $req = $this->db->prepare('SELECT c.id, c.comment, c.report, u.pseudo,
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
        public function countComments($report =-1)
        {
            $req = 'SELECT COUNT(*) FROM commentaires';

            if($report != -1)
            {
                $req.= ' WHERE report = ' .(int) $report;
            }

            $countComs = $this->db->query($req)->fetchColumn();

            return $countComs;
        }

        //Report comment
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
            $req = $this->db->prepare('INSERT INTO commentaires(post_id, user_id, comment, comment_date, report)
            VALUES(:post_id, :user_id, :comment, NOW(), 0)');

            $req->bindValue(':post_id', $comment->post_id(), \PDO::PARAM_INT);
            $req->bindValue(':user_id', $comment->user_id(), \PDO::PARAM_INT);
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
