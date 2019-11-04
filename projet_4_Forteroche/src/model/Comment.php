<?php
namespace model;

class Comment extends Entity
{
    //Attributs de l'objet
    private $id;
    private $author;
    private $post_id;
    private $comment;
    private $comment_date;

    //Constructor
    public function __construct(array $data)
    {
    $this->hydrate = $this->hydrate($data);
    }

    /*---------------------------------------
                    Setter Post
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

    public function setCommentdate($comment_date)
    {
        if(is_string($comment_date))
        {
            $this->comment_date = $comment_date;
        }
    }

    /*---------------------------------------
                    Getter Post
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

    public function comment_date()
    {
        return $this->comment_date;
    }
}
