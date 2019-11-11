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
        // $user = $this->user->verifPseudo($pseudo);
        if($User === false)
        {
            throw new Exception("Impossible de vous inscrire");
        }

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

    public function listUsers()
    {
        $Users = $this->user->getUsers();

        return $Users;
    }

    //User connexion method
    public function userConnect($pseudo)
    {
        $user = $this->user->getPseudo($pseudo);

        if (!$user)
        {
            throw new Exception("Pseudo invalide (controller)");
        }

        else
        {
            $passVerify = password_verify($_POST['pass'], $user['pass']);
            // var_dump($User);

            if($passVerify)
            {
                $_SESSION['id'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];
            }
            else
            {
                throw new \Exception("Mot de passe invalide (controller)");
            }
        }

        // return $user;
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
