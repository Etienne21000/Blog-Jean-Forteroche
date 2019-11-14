<?php
namespace model;

class PostManager extends Manager
{
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    /*------------------------------
    Test list posts
    with limit variables
    -------------------------------*/
    public function getPosts($start =-1, $limite = -1)
    {
        $Posts = [];

        $req = 'SELECT b.id, b.title, b.content, DATE_FORMAT(b.creation_date, \'%d/%m/%Y à %Hh%i\')
        AS creation_date, COUNT(c.id) AS num_com FROM billets AS b, commentaires AS c WHERE c.post_id = b.id GROUP BY b.id ORDER BY creation_date DESC';

        if ($start != -1 || $limite != -1)
        {
            $req .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $start;
        }

        $result = $this->db->query($req);

        while ($data = $result->fetch(\PDO::FETCH_ASSOC))
        {
            $post = new Post($data);
            $Posts[] = $post;
        }
        return $Posts;
    }

    public function getAllPosts($start =-1, $limite = -1)
    {
        $Posts = [];

        $req = 'SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\')
        AS creation_date, DATE_FORMAT(edition_date, \'%d/%m/%Y à %Hh%i\')
        AS edition_date FROM billets ORDER BY creation_date DESC';

        if ($start != -1 || $limite != -1)
        {
            $req .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $start;
        }

        $result = $this->db->query($req);

        while ($data = $result->fetch(\PDO::FETCH_ASSOC))
        {
            $post = new Post($data);
            $Posts[] = $post;
        }
        return $Posts;
    }

    public function countPosts()
    {
        $countPosts = $this->db->query('SELECT COUNT(*) FROM billets')->fetchColumn();

        return $countPosts;
    }

    // public function countComByPost()
    // {
    //     $req = $this->db->query($req = 'SELECT b.id, COUNT(c.id) AS num_com FROM billets AS b, commentaires AS c
    //     WHERE c.post_id = b.id GROUP BY b.id ORDER BY creation_date DESC');
    //
    //     $num_com = $req->fetch(\PDO::FETCH_ASSOC);
    //
    //     return $num_com;
    // }

    //Get post by id
    public function getOne($id)
    {
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\')
        AS creation_date FROM billets WHERE id = ?');
        $req->execute([$id]);
        $data = $req->fetch(\PDO::FETCH_ASSOC);
        $post = new Post($data);

        return $post;
    }
    // public function getOne($id)
    // {
    //     $req = $this->db->prepare('SELECT p.id, p.title, p.content, DATE_FORMAT(p.creation_date, \'%d/%m/%Y à %Hh%i\')
    //     AS creation_date FROM billets p INNER JOIN commentaires c ON c.post_id = p.id WHERE p.id = ?');
    //     $req->execute([$id]);
    //     $data = $req->fetch(\PDO::FETCH_ASSOC);
    //     $post = new Post($data);
    //
    //     return $post;
    // }

    //Methode to delete a post
    public function delete($id)
    {
        $req = $this->db->prepare('DELETE FROM billets WHERE id = ?');
        $req->execute([$id]);
    }

    //Methode add a post
    // public function add($title, $content)
    // {
    //     $req = $this->db->prepare('INSERT INTO billets(title, content, creation_date)
    //     VALUES(?,?, NOW())');
    //     $req->execute([
    //         $title,
    //         $content
    //     ]);
    // }

    public function add(Post $post)
    {
        $req = $this->db->prepare('INSERT INTO billets(title, content, creation_date)
        VALUES(:title, :content, NOW())');

        $req->bindValue(':title', $post->title());
        $req->bindValue(':content', $post->content());

        $req->execute();
    }

    //Methode update post
    public function update(Post $post)
    {
        $req = $this->db->prepare('UPDATE billets SET title = :title, content = :content, edition_date = NOW()
        WHERE id = :id');

        $req->bindValue(':title', $post->title());
        $req->bindValue(':content', $post->content());
        $req->bindValue(':id', $post->id(), \PDO::PARAM_INT);

        $req->execute();

    }
    // public function update($id, $title, $content)
    // {
    //     $req = $this->db->prepare('UPDATE billets SET title = ?, content = ?, edition_date = NOW()
    //     WHERE id = ?');
    //     $req->execute([
    //         $title,
    //         $content,
    //         $id
    //     ]);
    //
    // }
}
