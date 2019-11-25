<?php
namespace model;
// require_once 'model/Entity.php';

class User extends Entity
{
    //Object's attributes
    private $id;
    private $pseudo;
    private $pass;
    private $mail;
    private $user_date;
    private $user_role;
    private $user_slug;
    private $num_com;
    private $num_com_report;

    public function __construct(array $data)
    {
        $this->hydrate = $this->hydrate($data);
    }

    /*---------------------------------------
    User setters
    ----------------------------------------*/

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function setPseudo($pseudo)
    {
        if (is_string($pseudo))
        {
            $this->pseudo = $pseudo;
        }
    }

    public function setPassword($pass)
    {
        $this->pass = $pass;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function setInscriptiondate($user_date)
    {
        if(is_string($user_date))
        {
            $this->user_date = $user_date;
        }
    }

    public function setuserRole($user_role)
    {
        $this->user_role = (int)$user_role;
    }

    public function setUserSlug($user_slug)
    {
        if (is_string($user_slug))
        {
            $this->user_slug = $user_slug;
        }
    }

    public function setNumCom($num_com)
    {
        $this->num_com = (int)$num_com;
    }

    public function setNumComReport($num_com_report)
    {
        $this->num_com_report = (int)$num_com_report;
    }

    /*---------------------------------------
    User Getters
    ----------------------------------------*/

    public function id()
    {
        return $this->id;
    }

    public function pseudo()
    {
        return $this->pseudo;
    }

    public function passWord()
    {
        return $this->pass;
    }

    public function mail()
    {
        return $this->mail;
    }

    public function user_date()
    {
        return $this->user_date;
    }

    public function user_role()
    {
        return $this->user_role;
    }

    public function user_slug()
    {
        return $this->user_slug;
    }

    public function num_com()
    {
        return $this->num_com;
    }

    public function num_com_report()
    {
        return $this->num_com_report;
    }

}
