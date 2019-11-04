<?php
namespace model;

// use model\Post;

class PostManager extends Manager
{
    public function __construct()
    {
        $this->db = $this->dbConnect();
    }

    public function getPosts()
    {
        $Posts = [];
        $req = $this->db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\')
        AS creation_date FROM billets ORDER BY creation_date DESC LIMIT 0, 6');

        while ($data = $req->fetch(\PDO::FETCH_ASSOC))
        {
            $post = new Post($data);
            $Posts[] = $post;
        }
        return $Posts;
    }

    public function allPosts()
    {
        $Posts = [];
        $req = $this->db->query('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\')
        AS creation_date FROM billets ORDER BY creation_date DESC');

        while ($data = $req->fetch(\PDO::FETCH_ASSOC))
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
    public function getOne($post_id)
    {
        // $id = (int) $id;
        $req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\')
        AS creation_date FROM billets WHERE id = ?');
        $req->execute([$post_id]);
        // $post = $req->fetch(\PDO::FETCH_ASSOC);
        $data = $req->fetch(\PDO::FETCH_ASSOC);
        $post = new Post($data);

        return $post;
    }

    //Methode to delete a post
    public function delete($id)
    {
        $req = $this->db->prepare('DELETE FROM commentaires WHERE id = ?');
        $req->execute([$id]);
    }

    //Methode add a post
    public function add($title, $content)
    {
        $req = $this->db->prepare('INSERT INTO billets(title, content, creation_date)
        VALUES(?,?, NOW())');
        $req->execute([
            $title,
            $content
        ]);
    }
    // public function add(Post $post)
    // {
    //     $req = $this->db->prepare('INSERT INTO billets(title, content, creation_date)
    //     VALUES(?,?, NOW())');
    //     $req->execute([
    //         $post->title(),
    //         $post->content()
    //     ]);
    // }

    //Methode update post
    // public function update(Post $post)
    // {
    //     $req = $this->db->prepare('UPDATE billets SET title = :title, content = :, creation_date = NOW(),
    //     WHERE id = ?');
    //     $req->execute([$id, $title, $comment]);
    // }
}





// $nbPosts = [];
// $req = $this->db->query('SELECT COUNT(*) FROM billets');
// $data = $req->fetch(\PDO::FETCH_ASSOC);
// $nbPosts[] = $data;
// // var_dump($nbPosts);
// return $nbPosts;
