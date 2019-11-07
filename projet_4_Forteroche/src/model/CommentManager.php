<?php

namespace model;

class CommentManager extends Manager
{
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    //Get list of comment by post id
    public function getComments($post_id)
    {
        $Comments = [];
        $req = $this->db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires WHERE post_id = ? ORDER BY comment_date DESC LIMIT 0, 5');
        $req->execute([$post_id]);

        while ($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $comment = new Comment($data);
            $Comments[] = $comment;
        }
        return $Comments;
    }

    /*---------------------------------
    Get lasts comments à revoir
    ----------------------------------*/
    public function getLastComments()
    {
        $Comments = [];
        $req = $this->db->query('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires ORDER BY comment_date DESC LIMIT 0, 3');

        while ($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $comment = new Comment($data);
            $Comments[] = $comment;
        }
        return $Comments;
    }

    /*---------------------------------
    Get all comments
    ----------------------------------*/
    public function getAllComments()
    {
        $Comments = [];
        $req = $this->db->query('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires ORDER BY comment_date DESC');

        while ($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $comment = new Comment($data);
            $Comments[] = $comment;
        }
        return $Comments;
    }

    /*-------------------------
    Get comment by id à revoir dans le controller et index
    --------------------------*/
    public function getCom($id)
    {
        $req = $this->db->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires WHERE id = ?');
        $req->execute([$id]);

        $data = $req->fetch(\PDO::FETCH_ASSOC);
        $Comment = new Comment($data);

        return $Comment;
    }

    //Count total of comments
    public function countComments()
    {
        $countComs = $this->db->query('SELECT COUNT(*) FROM commentaires')->fetchColumn();

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
        $req = $this->db->prepare('UPDATE commentaires SET report = 1 WHERE id = ?');
        /*$reportedCom =*/ $req->execute([$id]);

        // return $reportedCom;
    }

    //Reported comments
    public function getReportedComments()
    {
        $req = $this->db->query('SELECT id, post_id, author, comment, report, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date
        FROM commentaires WHERE report = 1 ORDER BY comment_date DESC LIMIT 0, 3');

        while ($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $com = new Comment($data);
            $report[] = $com;
        }
        // $report = $req->execute([$id]);

        return $report;
    }

    //Show reported comments
    // $Comments = [];
    // $req = $this->db->query('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\')
    // AS comment_date FROM commentaires ORDER BY comment_date DESC');
    //
    // while ($data = $req->fetch(\PDO::FETCH_ASSOC))
    // {
    //     $comment = new Comment($data);
    //     $Comments[] = $comment;
    // }
    // return $Comments;

    // Create comment method (user)
    public function addComment($post_id, $author, $comment)
    {
        $req = $this->db->prepare('INSERT INTO commentaires(post_id, author, comment, comment_date)
        VALUES(?,?,?, NOW())');
        $newComment = $req->execute([
            $post_id,
            $author,
            $comment
        ]);

        return $newComment;
    }

    //Delet comment (admin session)
    public function deleteComment($id)
    {
        $req = $this->db->prepare('DELETE FROM commentaires WHERE id = ?');
        $req->execute([$id]);
    }

    //Update comment
    public function updateComment($id, $comment)
    {
        $req = $this->db->prepare('UPDATE commentaires SET comment = ?, comment_date = NOW()
        WHERE id = ?');
        /*$updateComment = */$req->execute([
        $id,
        $comment
    ]);

    // return $updateComment;
}
}
