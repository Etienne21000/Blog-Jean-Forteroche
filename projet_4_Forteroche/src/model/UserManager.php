<?php
namespace model;

class UserManager extends Manager
{
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    //Get signle user with role
    public function getUser($id)
    {
        $req = $this->db->prepare('SELECT u.id, u.pseudo, u.mail, u.user_role, u.user_slug, DATE_FORMAT(u.user_date, \'%d/%m/%Y à %Hh%i\')
        AS user_date, COUNT(c.id) AS num_com FROM users AS u LEFT OUTER JOIN commentaires AS c ON u.id = c.user_id WHERE u.id = :id');

        $req->bindValue('id', $id, \PDO::PARAM_INT);

        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);
        $user = new User($data);

        return $user;
    }

    //Get users with comments join
    public function getUsers($start =-1, $limite = -1)
    {
        $Users = [];

        $req = 'SELECT u.id, u.pseudo, u.mail, DATE_FORMAT(u.user_date, \'%d/%m/%Y à %Hh%i\')
        AS user_date, COUNT(c.id) AS num_com FROM users AS u LEFT OUTER JOIN commentaires AS c ON u.id = c.user_id GROUP BY u.id ORDER BY user_date DESC';

        if ($start != -1 || $limite != -1)
        {
            $req .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $start;
        }

        $req = $this->db->query($req);

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
        $req = $this->db->prepare('SELECT id, pseudo, pass, user_role FROM users WHERE pseudo = :pseudo');

        $req->bindValue('pseudo', $pseudo);

        $req->execute();

        $user = $req->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    //Verify if new pseudo is availlable
    public function verifPseudo($pseudo)
    {
        $req = $this->db->prepare('SELECT pseudo FROM users WHERE LOWER(pseudo) = :pseudo');

        $req->bindValue('pseudo', strtolower($pseudo));

        $req->execute();

        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    //Check if email exist already
    public function verifMail($mail)
    {
        $req = $this->db->prepare('SELECT mail FROM users WHERE mail = :mail');

        $req->bindValue(':mail', $mail);

        $req->execute();

        return $req->fetch(\PDO::FETCH_ASSOC);
    }

    //add user in db
    // public function add($pseudo, $mail, $pass)
    // {
    //     $req = $this->db->prepare('INSERT INTO users(pseudo, mail, pass, user_date, user_role)
    //     VALUES(?, ?, ?, NOW(), 0)');
    //     $newUser = $req->execute([
    //         $pseudo,
    //         $mail,
    //         $pass
    //     ]);
    // }
    public function add(User $user)
    {
        $req = $this->db->prepare('INSERT INTO users(pseudo, mail, pass, user_date, user_role)
        VALUES(:pseudo, :mail, :pass, NOW(), 1)');

        $req->bindValue(':pseudo', $user->pseudo());
        $req->bindValue(':mail', $user->mail());
        $req->bindValue(':pass', $user->passWord());

        /*$newUser = */$req->execute();
    }

    //delete user
    public function deleteUser($id)
    {
        $req = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->execute();
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
