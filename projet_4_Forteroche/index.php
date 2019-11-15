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
        /*---------------------------------------------------
        All actions which do not need any specific acces role
        ----------------------------------------------------*/

        //Get Posts and 3 last comments
        if ($_GET['action'] == 'Accueil')
        {
            $Posts = $postController->listPosts();
            $Comments = $commentController->lastCom();

            require 'src/view/indexView.php';
        }

        elseif ($_GET['action'] == 'post')
        {
            $Posts = $postController->post();
            // $countPosts = $postController->nbPost();

            require 'src/view/chapterView.php';
        }

        //Get post with its comments
        elseif ($_GET['action'] == 'listComments')
        {
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $post = $postController->getPost($_GET['id']);
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
            if(isset($_SESSION['pseudo']) && isset($_SESSION['id']))
            {
                // if(isset($_GET['post_id']) && $_GET['post_id'] > 0)
                if(isset($_GET['id']) && $_GET['id'] > 0)
                {
                    // if(isset($_GET['user_id']) && isset($_GET['user_id']) > 0)
                    // {
                        if(!empty($_POST['author']) && !empty($_POST['comment']))
                        {
                        $commentController->newComment(/*$_GET['post_id'], $_GET['user_id'], $_POST['author'], $_POST['comment']*/);
                        }
                        else
                        {
                            throw new Exception("vous n'avez pas remplis tous les champs! (rooter)");
                        }
                    // }
                    // else
                    // {
                    //     throw new \Exception("Aucun identifiant d'utilisateur envoyé");
                    // }
                }
                else
                {
                    throw new \Exception("impossible de commenter");
                }

                header('Location: index.php?action=listComments&id=' . $_GET['id']);
            }

            else
            {
                require 'src/view/inscriptionUser.php';
                // throw new \Exception("Vous devez être connecté pour laisser un commentaire.");
            }

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
            // header('Location: index.php&action=listComments&id=' . $_GET['id']);
            echo 'Le message a été signalé';
        }

        elseif ($_GET['action'] == 'AdminConnexion')
        {
            require 'src/view/adminConnexionView.php';
        }

        elseif ($_GET['action'] == 'inscription')
        {
            require 'src/view/inscriptionUser.php';
        }

        //User inscription public
        elseif ($_GET['action'] == 'userInscription')
        {
            $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
            $_POST['mail'] = htmlspecialchars($_POST['mail']);
            $_POST['pass'] = htmlspecialchars($_POST['pass']);
            $_POST['confirmePass'] = htmlspecialchars($_POST['confirmePass']);
            $errors = array();

            $validate = true;

            //Verify pseudo
            if(empty($_POST['pseudo']) || strlen($_POST['pseudo']) > 100 || !preg_match("#^[a-zà-ùA-Z0-9-\s_-]+$#", $_POST['pseudo']))
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
                // $hash_pass = $_POST['pass'];
                if (empty($userController->pseudoExist($_POST['pseudo'])) && empty($userController->mailExist($_POST['mail'])))
                {
                    $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);

                    $userController->addUser($_POST['pseudo'], $_POST['mail'], $_POST['pass']);

                    require 'src/view/adminConnexionView.php';
                }
                else {
                    echo '<p>Ce pseudo est déjà utilisé ou le mail est invalide</p>';
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
                if (empty($_POST['pseudo']) || empty($_POST['pass']))
                {
                    throw new Exception("<p>Vous n'avez pas rempli tous les champs</p>");
                    $validate = false;
                }

                //Verify length of strings
                if (strlen($_POST['pseudo']) > 100 || strlen($_POST['pass']) > 255)
                {
                    throw new Exception("champ invalide (rooter)");
                    $validate = false;
                }

                //if form is ok validate retunr true
                if ($validate = true)
                {
                    $userController->userConnect($_POST['pseudo']);
                    // header('Location: index.php&action=Admin');
                    // require 'src/view/AdminHomeView.php';
                    header('Location: index.php?action=Admin');
                    // $userManager = new UserManager();
                }
            }
        }

        //Disconnect user
        elseif ($_GET['action'] == 'discUser')
        {
            $userController->disconnectUser();

            header('Location: index.php?action=Accueil');
            // require 'src/view/indexView.php';
        }

        /*---------------------------------------------------
        Admin actions with specific acces role = 1
        ----------------------------------------------------*/

        /*---------------------------
                1. post's actions
        ---------------------------*/

        elseif ($_GET['action'] == 'AddPostAdmin')
        {
            // if(!empty($_SESSION['pseudo']) && $_SESSION['user_role'] == 1)
            // {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            require 'src/view/adminPost.php';
        }

        elseif ($_GET['action'] == 'addPost')
        {
            //Admin session action
            // if(isset($_SESSION['pseudo']) && $_SESSION['user_role'] = 1)
            // {
            if(!empty($_POST['title']) && !empty($_POST['content']))
            {
            $postController->addPost(/*htmlspecialchars($_POST['title']), htmlentities($_POST['content'])*/);
            }
            else
            {
                throw new Exception("vous n'avez pas remplis tous les champs pour poster votre billet! (rooter)");
            }

            header('Location: index.php?action=postAdmin');

            // require 'src/view/listPostAdminView.php';
        }

        elseif ($_GET['action'] == 'deletePost')
        {
            if(isset($_GET['id']) && $_GET['id'] > 0)
            {
                $postController->deletePost($_GET['id']);
            }
            else
            {
                throw new Exception("Impossible de supprimer cet article. (rooter)");
            }
            // require 'src/view/listPostAdminView.php';
            header('Location: index.php?action=postAdmin');
        }

        //Update post view
        elseif ($_GET['action'] == 'postUpdate')
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $post = $postController->getPost($_GET['id']);

            require 'src/view/adminUpdatePostView.php';
        }

        //Update post
        elseif ($_GET['action'] == 'updatePost')
        {
            // $post = $postController->getPost();
            if(isset($_GET['id']) && $_GET['id'] > 0)
            {
                if(!empty($_POST['content']) && !empty($_POST['title']))
                {
                    $postController->updatePost($_GET['id'], htmlspecialchars($_POST['title']), htmlentities($_POST['content']));
                }
                else
                {
                    throw new Exception('impossible de mettre à jour le billet');
                }
            }
            else
            {
                throw new Exception('Aucun id de billet envoyé (rooter)');
            }
            // header('Location: index.php?action=postAdmin');
            header('Location: index.php?action=postViewAdmins&id=' . $_GET['id']);
            // require 'src/view/adminPostView.php';

            // header('Location: index.php&action=AddPostView&id=' . $_GET['id']);
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


        /*---------------------------
            2. comment's actions
        ---------------------------*/

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

        //Update comment view
        elseif ($_GET['action'] == 'commentUpdate')
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $Comment = $commentController->getOne($_GET['id']);

            require 'src/view/adminEditComment.php';
        }

        //Update comment
        elseif ($_GET['action'] == 'updateComment')
        {
            if(isset($_GET['id']) && $_GET['id'] > 0)
            {
                // if(!empty($_POST['comment']))
                // {
                    $commentController->updateCom($_GET['id'], htmlentities(($_POST['comment'])));
                // }
                // else
                // {
                //     throw new \Exception("Vous n'avez pas rempli tous les champs");
                // }
            }
            else
            {
                throw new Exception("Aucun identifiant de commentaire envoyé (rooter)");
            }

            header('Location: index.php?action=signleCom&id=' .$_GET['id']);
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

        //Get signle post admin à revoir
        elseif ($_GET['action'] == 'signleCom')
        {
            $countComs = $commentController->nbCom();
            $countPosts = $postController->nbPost();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $Comment = $commentController->getOne($_GET['id']);

            require 'src/view/adminSingleCom.php';
        }

        //Admin reported comment list view
        elseif ($_GET['action'] == 'reportList')
        {
            $countComs = $commentController->nbCom();
            $countPosts = $postController->nbPost();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $report = $commentController->getAllReported();

            require 'src/view/adminReportedCom.php';
        }

        //Validate reported comment
        elseif ($_GET['action'] == 'validateCom')
        {

                if (isset($_GET['id']) && $_GET['id'] > 0)
                {
                    $validCom = $commentController->validCom($_GET['id']);
                }

                else
                {
                    throw new \Exception("Impossible de signaler ce commentaire car aucun identifiant de commentaire envoyé (rooter)");
                }

                header('Location: index.php?action=reportList');

            // header('Location: index.php?action=signleCom&id=' . $_GET['id']);
        }

        /*---------------------------
            3. Admin's actions
        ---------------------------*/

        elseif ($_GET['action'] == 'Admin')
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            $Posts = $postController->adminPost();
            $Comments = $commentController->lastCom();
            $Users = $userController->listUsers();
            $report = $commentController->getReportedCom();

            require 'src/view/AdminHomeView.php';
        }

        elseif ($_GET['action'] == 'postViewAdmins')
        {
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $post = $postController->getPost($_GET['id']);
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
            // header('Location: index.php?action=Accueil');
            require 'src/view/adminPostView.php';
        }

        elseif ($_GET['action'] == 'listUsers')
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $Users = $userController->allUsers();

            require 'src/view/adminListUsers.php';
        }

        /*---------------------------
            3. Admin's actions
        ---------------------------*/
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
