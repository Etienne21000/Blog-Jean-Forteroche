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
        AS comment_date FROM commentaires WHERE post_id = ? && report = 0 ORDER BY comment_date DESC LIMIT 0, 5');
        $req->execute([$id]);

        while ($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $comment = new Comment($data);
            $Comments[] = $comment;
        }
        return $Comments;
    }

    /*------------------------------
    Test list comments
    with limit variables
    -------------------------------*/

    public function getAllComments($start =-1, $limite = -1)
    {
        $Comments = [];

        $req = 'SELECT c.id, c.user_id, c.author, c.comment, DATE_FORMAT(c.comment_date, \'%d/%m/%Y à %Hh%i\')
        AS comment_date FROM commentaires c INNER JOIN users u ON u.id = c.user_id AND u.pseudo = c.author WHERE report = 0 ORDER BY comment_date DESC';

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
        $req->execute([$id]);
    }

    //Validate a reported comment
    public function validateCom($id)
    {
        $req = $this->db->prepare('UPDATE commentaires SET report = 0 WHERE id = ?');
        $req->execute([$id]);
    }

    /*------------------------------
    Test list reported comments
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

    //Test jointure table
    // public function addComment($post_id, $user_id, $comment)
    // {
    //     $req = $this->db->prepare('INSERT INTO commentaires(post_id, user_id, comment, comment_date, report)
    //     -- SELECT c.user_id FROM users u INNER JOIN commentaires c ON c.user_id = u.id
    //     VALUES(?,?,?, NOW(), 0)');
    //
    //     $newComment = $req->execute([
    //         $post_id,
    //         $user_id,
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

        /*$newComment = */
        $req->execute();

        // return $newComment;
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
        $req = $this->db->prepare('UPDATE commentaires SET comment = ?, report = 0, edition_com_date = NOW()
        WHERE id = ?');
        $req->execute([
            $comment,
            $id
        ]);
    }
}

//Count comments by post_id à revoir
// public function countComByPost($post_id)
// {
//     $req = $this->db->prepare('SELECT COUNT(*) FROM commentaires WHERE post_id = ?');
//     $req->execute([$post_id]);
//     $countByPost = $req->fetchColumn();
//
//     return $countByPost;
// }

// $$newComment->fetch(\PDO::FETCH_ASSOC);
// $req->execute([
//     'post_id' => (int) $post_id,
//     'author' => $author,
//     'comment'=> $comment
// ]);
