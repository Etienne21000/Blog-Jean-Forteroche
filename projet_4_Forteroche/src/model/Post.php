<?php
namespace model;

class Post extends Entity
{
    //Attributs de l'objet
    private $id;
    private $title;
    private $content;
    private $creation_date;
    private $edition_date;
    private $num_com;
    // private $date_update;

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

    public function setTitle($title)
    {
        if (is_string($title))
        {
            $this->title = $title;
        }
    }

    public function setContent($content)
    {
        if (is_string($content))
        {
            $this->content = $content;
        }
    }

    public function setCreationdate($creation_date)
    {
        if(is_string($creation_date))
        {
            $this->creation_date = $creation_date;
        }
    }

    public function setEditiondate($edition_date)
    {
        if(is_string($edition_date))
        {
            $this->edition_date = $edition_date;
        }
    }

    public function setNumcom($num_com)
    {
            $this->num_com = (int)$num_com;
    }

    /*---------------------------------------
    Getter Post
    ----------------------------------------*/

    public function id()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function content()
    {
        return $this->content;
    }

    public function creation_date()
    {
        return $this->creation_date;
    }

    public function edition_date()
    {
        return $this->edition_date;
    }

    public function num_com()
    {
        return $this->num_com;
    }
}
