<?php
session_start();

require 'vendor/autoload.php';
use controller\PostController;
use controller\CommentController;
use controller\UserController;
use model\UserManager;

$postController = new PostController();
$commentController = new CommentController();
$userController = new UserController();


try
{
    if (isset($_GET['action']))
    {
        //Get Posts and 3 last comments
        if ($_GET['action'] == 'Accueil')
        {
            $Posts = $postController->listPosts();
            $Comments = $commentController->lastCom();
            // $countByPost = $commentController->nbComByPost($_GET['post_id']);
            // $Posts = $commentController->nbComById();

            require 'src/view/indexView.php';
        }

        elseif ($_GET['action'] == 'post')
        {
            $Posts = $postController->post();
            $countPosts = $postController->nbPost();

            require 'src/view/chapterView.php';
        }

        elseif ($_GET['action'] == 'addPost')
        {
            if(!empty($_POST['title']) && !empty($_POST['content']))
            {
                $postController->addPost($_GET['id'], $_POST['title'], $_POST['content']);
            }
            else
            {
                throw new Exception("vous n'avez pas remplis tous les champs pour poster votre billet! (rooter)");
            }

            header('Location: index.php?action=listPosts' .$_GET['id']);
        }

        //Get post with its comments
        elseif ($_GET['action'] == 'listComments')
        {
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $post = $postController->getPost();
                $Comments = $commentController->getCom($_GET['id']);
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

        //Update post
        elseif ($_GET['action'] == 'postUpdate')
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();

            require 'src/view/adminUpdatePostView.php';
        }

        //Update post
        elseif ($_GET['action'] == 'updatePost')
        {
            if(isset($_GET['id']) && $_GET['id'] > 0)
            {
                if(!empty($_POST['content']))
                {
                    $postController->updatePost($_GET['id'], $_POST['title'], $_POST['content']);
                }
                else
                {
                    throw new Exception('impossible de mettre à jour le billet');
                }
            }
            else
            {
                throw new Exception('Aucun id de billet envoyé');
            }

            header('Location: index.php&action=AddPostView&id=' . $_GET['id']);
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

            header('Location: index.php?action=listComments&id=' .$_GET['id']);
        }

        //Report comment by user
        elseif ($_GET['action'] == 'reportComment')
        {
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $reportedCom = $commentController->reportCom($_GET['id']);
            }

            else
            {
                throw new \Exception("Impossible de signaler ce commentaire car aucun identifiant de commentaire envoyé (rooter)");
            }
            echo 'Le message a été signalé';
        }

        elseif ($_GET['action'] == 'adminCom')
        {
            $Comments = $commentController->allCom();
            $countComs = $commentController->nbCom();
            $countPosts = $postController->nbPost();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            // require 'src/view/AdminComView.php';
            require 'src/view/adminCommentList.php';
        }

        //Admin reported comment list view
        elseif ($_GET['action'] == 'reportList')
        {
            $countComs = $commentController->nbCom();
            $countPosts = $postController->nbPost();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            $report = $commentController->getReportedCom();


            require 'src/view/adminReportedCom.php';
        }

        //User actions
        //Add post
        elseif ($_GET['action'] == 'AddPostAdmin')
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            require 'src/view/adminPost.php';
        }

        // //Update post
        // elseif ($_GET['action'] == 'updatePost')
        // {
        //     require 'src/view/adminPost.php';
        // }

        elseif ($_GET['action'] == 'AdminConnexion')
        {
            require 'src/view/adminConnexionView.php';
        }

        elseif ($_GET['action'] == 'inscription')
        {
            require 'src/view/inscriptionUser.php';
        }

        elseif ($_GET['action'] == 'Admin')
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            $Posts = $postController->listPosts();
            $Comments = $commentController->lastCom();
            $Users = $userController->listUsers();
            $report = $commentController->getReportedCom();

            require 'src/view/AdminHomeView.php';
        }

        //Liste of all posts admin page
        elseif ($_GET['action'] == 'postAdmin')
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            $Posts = $postController->post();
            // $Comments = $commentController->lastCom();
            // $Users = $userController->listUsers();

            require 'src/view/listPostAdminView.php';
        }

        //Inscription user
        elseif ($_GET['action'] == 'userInscription')
        {
            $_POST['user'] = htmlspecialchars($_POST['user']);
            $_POST['mail'] = htmlspecialchars($_POST['mail']);
            $_POST['pass'] = htmlspecialchars($_POST['pass']);
            $_POST['confirmePass'] = htmlspecialchars($_POST['confirmePass']);
            $errors = array();

            $validate = true;

            //Verify pseudo
            if(empty($_POST['user']) || strlen($_POST['user']) > 100 || !preg_match("#^[a-zà-ùA-Z0-9-\s_-]+$#", $_POST['user']))
            {
                $validate = false;
                throw new Exception("Pseudo vide ou incorrecte");
                // $errors['user'] = 'Pseudo vide ou incorrecte';
                // die();
            }

            //Verify mail
            if(empty($_POST['mail']) || strlen($_POST['mail']) > 255 || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
            {
                $validate = false;
                throw new Exception("Adresse mail invalide");
            }

            //Verufy passWord
            if(empty($_POST['pass']) || strlen($_POST['pass']) > 255 || !preg_match("#^[a-zA-Z0-9_-]+.{8,}$#", $_POST['pass']))
            {
                $validate = false;
                throw new Exception("Mot de passe invalide");
                // $errors['pass'] = 'Mot de pass invalide';
                // die();
            }

            //Confirm pass
            if (($_POST['pass'] !== $_POST['confirmePass']))
            {
                $validate = false;
                throw new Exception("Confirmez à nouveau votre mot de passe");
                // $errors['confirmePass'] = 'Confirmez à nouveau votre mot de passe';
                // die();
            }

            if($validate = true)
            {
                $hash_pass = $_POST['pass'];
                if (empty($userController->pseudoExist($_POST['user'])) && empty($userController->mailExist($_POST['mail'])))
                {
                    $hash_pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);

                    $User = $userController->addUser($_POST['user'], $_POST['mail'], $_POST['pass']);

                    require 'src/view/adminConnexionView.php';
                }
                else {
                    echo '<p>Ce pseudo est déjà utilisé ou le mail est invalide</p>';
                    // die();
                }
            }
        }

        //User connection
        elseif ($_GET['action'] == 'connectUser')
        {
            if (!empty($_POST))
            {
                $validate = true;

                //verify if empty fields occured
                if (empty($_POST['user']) || empty($_POST['pass']))
                {
                    throw new Exception("<p>Vous n'avez pas rempli tous les champs</p>");
                    $validate = false;
                }

                //Verify length of strings
                if (strlen($_POST['user']) > 100 || strlen($_POST['pass']) > 255)
                {
                    throw new Exception("champ invalide (rooter)");
                    $validate = false;
                }

                //if form is ok validate retunr true
                if ($validate = true)
                {
                $user = $userController->userConnect($_POST['user']);
                // header('Location: index.php&action=Admin');
                require 'src/view/AdminHomeView.php';
                    // $userManager = new UserManager();
                }
            }
        }

        //Disconnect user
        elseif ($_GET['action'] == 'discUser')
        {
            $userController->disconnectUser();

            require 'src/view/indexView.php';
        }

        elseif ($_GET['action'] == 'postViewAdmins')
        {
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $post = $postController->getPost();
                $countPosts = $postController->nbPost();
                $countComs = $commentController->nbCom();
                $countUsers = $userController->nbUsers();
                $countReport = $commentController->nbReported();
                // $Comment = $commentController->getCom();
            }
            else
            {
                throw new Exception("Aucun identifiant de billet ne correspond (rooter)");
            }
            require 'src/view/adminPostView.php';
        }
    }
    else
    {
        $Posts = $postController->listPosts();
        $Comments = $commentController->lastCom();
        // $countByPost = $commentController->nbComByPost();

        require 'src/view/indexView.php';
    }
}
catch (Exception $e)
{
    echo '<strong>Erreur</strong> : une erreur s\'est produite : ' . $e->getMessage();
}
