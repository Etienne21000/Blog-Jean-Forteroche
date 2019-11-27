<?php
namespace controller;

use model\UserManager;
use model\User;

class UserController
{
    private $user;

    public function __construct()
    {
        $this->user = new UserManager();
    }

    //Add user
    public function addUser($pseudo, $mail, $pass)
    {
        $User = new User(['data']);

        $User->setPseudo($pseudo);
        $User->setMail($mail);
        $User->setPassword($pass);

        $this->user->add($User);
    }

    //Delete user
    public function deleteU($id)
    {
        $User = $this->user->deleteUser($id);
    }
    //Call verifPseudo method
    public function pseudoExist($pseudo)
    {
        $user = $this->user->verifPseudo($pseudo);

        return $user;
    }

    //Call verifMail method from User Manager
    public function mailExist($mail)
    {
        $user = $this->user->verifMail($mail);

        return $user;
    }

    public function nbUsers()
    {
        $countUsers = $this->user->countUsers();

        return $countUsers;
    }

    //Get 3 last users on admin home page
    public function listUsers()
    {
        $Users = $this->user->getUsers($start = 0, $limite = 3);

        return $Users;
    }

    //Get all users from users list
    public function allUsers()
    {
        $Users = $this->user->getUsers();

        return $Users;
    }

    //Get single user infos
    public function getOneUser($id)
    {
        $user = $this->user->getUser($id, $report = 0);

        return $user;
    }

    //Get single user with reported comment
    public function getUserReport($id)
    {
        $user_report = $this->user->getUser($id, $report = 1);

        return $user_report;
    }

    //User connexion method
    public function userConnect($pseudo)
    {
        $user = $this->user->getPseudo($pseudo);

        return $user;
    }

    //Disconnect user
    public function disconnectUser()
    {
        $_SESSION = array();
        session_destroy();

        setcookie('pass', '');
        setcookie('hash_pass', '');
    }
}
