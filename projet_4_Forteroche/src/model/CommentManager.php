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

    //Get comment by id
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

    //Count comments by post
    // public function countComId()
    // {
    //     $req = $this->db->prepare('SELECT COUNT(*) FROM commentaires WHERE post_id = ?');
    //     $req->execute([$post_id]);
    //     $countId = $req->fetch(\PDO::FETCH_ASSOC);
    //
    //     return $countId;
    // }

    //method to report a comment
    public function reportComment($id)
    {

    }

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

// public function addComment(Comment $comment)
// {
//     $req = $this->db->prepare('INSERT INTO commentaires(post_id, author, comment, comment_date)
//     VALUES(:post_id, :author,:comment, NOW())');
//     $newComment = $req->execute([
//         'post_id' => $comment->post_id(),
//         'author' => $comment->author(),
//         'comment' => $comment->comment()
//     ]);
//
//     return $newComment;
// }
