<?php
session_start();

require 'vendor/autoload.php';
use controller\PostController;
use controller\CommentController;

$postController = new PostController();
$commentController = new CommentController();


try
{
    if (isset($_GET['action']))
    {
        //Get Posts and 3 last comments
        if ($_GET['action'] == 'Accueil')
        {
            $Posts = $postController->listPosts();
            $Comments = $commentController->lastCom();
            // $Posts = $commentController->nbComById();

            require 'src/view/indexView.php';
        }

        elseif ($_GET['action'] == 'post')
        {
            $Posts = $postController->post();
            $countPosts = $postController->nbPost();

            require 'src/view/chapterView.php';
        }

        //Get post with its comments
        elseif ($_GET['action'] == 'listComments')
        {
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $post = $postController->getPost();
                $Comment = $commentController->getCom();
            }
            else
            {
                throw new Exception("Aucun identifiant de billet ne correspond (rooter)");
            }
            require 'src/view/postView.php';
        }

        //Add comment
        elseif ($_GET['action'] == 'addComment')
        {
            if(isset($_GET['id']) && $_GET['id'] > 0)
            {
                if(!empty($_POST['author']) && !empty($_POST['comment']))
                {
                    $commentController->newComment($_GET['id'], $_POST['author'], $_POST['comment']);
                }
                else
                {
                    throw new Exception("vous n'avez pas remplis tous les champs! (rooter)");
                }
            }

            header('Location: index.php?action=listComments&id=' . $_GET['id']);
        }

        //Delete comment
        elseif ($_GET['action'] == 'deleteCom')
        {
            if(isset($_GET['id']) && $_GET['id'] > 0)
            {
                $commentController->deleteCom($_GET['id']);
            }
            else
            {
                throw new Exception("Impossible de supprimer ce commentaire. (rooter)");
            }

            header('Location: index.php?action=listComments&id=' . $_GET['post_id']);
        }

        //Update comment
        elseif ($_GET['action'] == 'updateComment')
        {
            if(isset($_GET['id']) && $_GET['id'] > 0)
            {
                if(!empty($_POST['comment']))
                {
                    $commentController->updateCom($_GET['id'], $_POST['comment']);
                    // header('Location: index.php?action=listComments&id=' .$_GET['id']);
                }
                else
                {
                    throw new \Exception("Vous n'avez pas rempli tous les champs");
                }
            }
            else
            {
                throw new Exception("Aucun identifiant de commentaire envoyé (rooter)");
            }

            // require 'src/view/postView.php' $post_id;

            header('Location: index.php?action=listComments&id=' .$_GET['id']);
        }
        
    }
    else
    {
        $Posts = $postController->listPosts();
        $Comments = $commentController->lastCom();

        require 'src/view/indexView.php';
    }
}
catch (Exception $e)
{
    echo '<strong>Erreur</strong> : une erreur s\'est produite : ' . $e->getMessage();
}
