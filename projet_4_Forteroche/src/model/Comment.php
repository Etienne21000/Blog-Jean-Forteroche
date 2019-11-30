<?php
namespace model;

class Comment extends Entity
{
    //Attributs de l'objet
    private $id;
    private $author;
    private $post_id;
    private $comment;
    private $report;
    private $comment_date;
    private $edition_com_date;
    private $user_id;
    private $pseudo;

    //Constructor
    public function __construct(array $data)
    {
        $this->hydrate = $this->hydrate($data);
    }

    /*---------------------------------------
    Setter Comments
    ----------------------------------------*/

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function setAuthor($author)
    {
        if (is_string($author))
        {
            $this->author = $author;
        }
    }

    public function setIdpost($post_id)
    {
        $this->post_id = (int)$post_id;
    }

    public function setComment($comment)
    {
        if (is_string($comment))
        {
            $this->comment = $comment;
        }
    }

    public function setreport($report)
    {
        $this->report = (bool)$report;
    }

    public function setCommentdate($comment_date)
    {
        if(is_string($comment_date))
        {
            $this->comment_date = $comment_date;
        }
    }

    public function setEditedCommentdate($edition_com_date)
    {
        if(is_string($edition_com_date))
        {
            $this->edition_com_date = $edition_com_date;
        }
    }

    public function setUserId($user_id)
    {
        $this->user_id = (int)$user_id;
    }

    public function setPseudo($pseudo)
    {
        if(is_string($pseudo))
        {
            $this->pseudo = $pseudo;
        }
    }

    /*---------------------------------------
    Getter Comments
    ----------------------------------------*/

    public function id()
    {
        return $this->id;
    }

    public function author()
    {
        return $this->author;
    }

    public function post_id()
    {
        return $this->post_id;
    }

    public function comment()
    {
        return $this->comment;
    }

    public function report()
    {
        return $this->report;
    }

    public function comment_date()
    {
        return $this->comment_date;
    }

    public function comment_edited_date()
    {
        return $this->edition_com_date;
    }

    public function user_id()
    {
        return $this->user_id;
    }

    public function pseudo()
    {
        return $this->pseudo;
    }
}
