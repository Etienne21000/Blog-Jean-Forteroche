<?php
namespace model;

class PostManager extends Manager
{
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    /*------------------------------
            Get All posts
            with variable limit
    -------------------------------*/
    public function getPosts($start = -1, $limite = -1)
    {
        $Posts = [];

        $req = 'SELECT b.id, b.title, b.content, DATE_FORMAT(b.creation_date, \'%d/%m/%Y à %Hh%i\')
        AS creation_date, DATE_FORMAT(b.edition_date, \'%d/%m/%Y à %Hh%i\') AS edition_date,
        COUNT(c.id) AS num_com FROM billets AS b LEFT JOIN commentaires AS c
        ON b.id = c.post_id GROUP BY b.id ORDER BY b.creation_date DESC';

        if ($start != -1 || $limite != -1)
        {
            $req .= ' LIMIT '. (int) $limite .' OFFSET ' . (int) $start;
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

    //Get post by id
    public function getOne($id)
    {
        $req = $this->db->prepare('SELECT b.id, b.title, b.content, DATE_FORMAT(b.creation_date, \'%d/%m/%Y à %Hh%i\')
        AS creation_date,COUNT(c.id) AS num_com FROM billets AS b LEFT JOIN commentaires AS c
        ON b.id = c.post_id WHERE b.id = :id AND c.report = 0');

        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->execute();

        $data = $req->fetch(\PDO::FETCH_ASSOC);
        $post = new Post($data);

        return $post;
    }

    //Methode to delete a post
    public function delete($id)
    {
        $req = $this->db->prepare('DELETE FROM billets WHERE id = :id');
        $req->bindValue(':id', $id, \PDO::PARAM_INT);
        $req->execute();
    }

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
}
