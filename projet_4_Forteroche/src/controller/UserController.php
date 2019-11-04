<?php
namespace controller;

use model\UserManager;

class UserController
{
    private $user;

    public function __construct()
    {
        $this->user = new UserManager();
    }

    public function addUser($pseudo, $mail, $pass)
    {
        $User = $this->user->add($pseudo, $mail, $pass);
        if($User === false)
        {
            throw new Exception("Impossible de vous inscrire");
        }
    }

    public function pseudoExist($pseudo)
    {
        $User = $this->user->verifPseudo($pseudo);
    }

    public function nbUsers()
    {
        $countUsers = $this->user->countUsers();

        return $countUsers;
    }

    public function listUsers()
    {
        $Users = $this->user->getUsers();

        return $Users;
    }

    public function userConnect($pseudo)
    {
        $User = $this->user->getPseudo($pseudo);

        $passVerify = password_verify($_POST['pass'], $User->passWord());

        if($passVerify)
        {
            session_start();
            $_SESSION['id'] = $User->id();
            $_SESSION['pseudo'] = $User->pseudo();

            // header('Location: index.php&action=Admin');
        }
        else
        {
            throw new \Exception("Mot de passe incorrect");
        }

        return $User;
    }
}
