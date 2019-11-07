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

        // if (empty($this->user->verifPseudo($_POST['user']))
        // if($user)
        // {
        //     throw new Exception("Ce pseudo existe déjà");
        // }
    }

    // public function checkUserPseudo($pseudo)
    // {
    //     $pseudo = $this->user->verifPseudo($pseudo);
    // }

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

    public function userConnect($pseudo)
    {
        $userConnect = $this->user->getPseudo($pseudo);

        // $passVerify = password_verify($_POST['pass'], $data['pass']);
        //
        // if(!$passVerify)
        // {
        //     throw new \Exception("Mot de passe incorrect");
        // }
        //
        // else
        // {
        //     if($passVerify)
        //     {
        //         session_start();
        //         $_SESSION['id'] = $data->id();
        //         $_SESSION['pseudo'] = $data->pseudo();
        //     }
        //     else
        //     {
        //         throw new \Exception("Mot de passe erroné");
        //     }
        }


        // $user = password_verify($_POST['pass'], $userConnect['pass']);
        //
        // if($passVerify)
        // {
        //     session_start();
        //     $_SESSION['id'] = $User->id();
        //     $_SESSION['pseudo'] = $User->pseudo();
        //
        //     // header('Location: index.php&action=Admin');
        // }
        // else
        // {
        //     throw new \Exception("Mot de passe incorrect");
        // }

        // return $User;
    // }
}
