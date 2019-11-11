<?php
namespace model;

class UserManager extends Manager
{
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    //Get 3 last users
    public function getUsers()
    {
        $Users = [];
        $req = $this->db->query('SELECT id, pseudo, mail, DATE_FORMAT(user_date, \'%d/%m/%Y à %Hh%i\')
        AS user_date FROM users ORDER BY user_date DESC LIMIT 0, 3');

        while ($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $user = new User($data);
            $Users[] = $user;
        }
        return $Users;
    }

    //Check if pseudo exist to connect user
    public function getPseudo($pseudo)
    {
        $req = $this->db->prepare('SELECT id, pseudo, pass FROM users WHERE pseudo = ?');
        $req->execute([
            $pseudo
        ]);
        $user = $req->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    //Verify if new pseudo is availlable
    public function verifPseudo($pseudo)
    {
        $req = $this->db->prepare('SELECT pseudo FROM users WHERE LOWER(pseudo) = ?');
        $req->execute([
            strtolower($pseudo)
        ]);

        return $req->fetch(\PDO::FETCH_ASSOC);

    }

    //Check if email exist already
    public function verifMail($mail)
    {
        $req = $this->db->prepare('SELECT mail FROM users WHERE mail = ?');
        $req->execute([
            $mail
        ]);

        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    //add user in db
    public function add($pseudo, $mail, $pass)
    {
        $req = $this->db->prepare('INSERT INTO users(pseudo, mail, pass, user_date, user_role)
        VALUES(?, ?, ?, NOW(), 0)');
        $newUser = $req->execute([
            $pseudo,
            $mail,
            $pass
        ]);
    }

    //Count users
    public function countUsers()
    {
        $countUsers = $this->db->query('SELECT COUNT(*) FROM users')->fetchColumn();

        return $countUsers;
    }

}

// $data = $req->fetch(\PDO::FETCH_ASSOC);

// if(!$data)
// {
//     return false;
// }
// else
// {
//     return new User($data);
// }
