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

        require 'src/view/front_end/indexView.php';
    }

    elseif ($_GET['action'] == 'post')
    {
        $Posts = $postController->post();

        require 'src/view/front_end/chapterView.php';
    }

    //Get post with its comments
    elseif ($_GET['action'] == 'listComments')
    {
        if (isset($_GET['id']) && $_GET['id'] > 0)
        {
            $post = $postController->getPost($_GET['id']);
            $Comments = $commentController->getCom($_GET['id']);

            require 'src/view/front_end/postView.php';
        }

        else
        {
            $postController->errors();
        }
    }

    //Report comment by user revoir la redirection id
    elseif ($_GET['action'] == 'reportComment')
    {
        if (isset($_GET['id']) && $_GET['id'] > 0)
        {
            $reportedCom = $commentController->reportCom($_GET['com_id']);
            $post = $postController->getPost($_GET['id']);

            header('Refresh: 2; index.php?action=listComments&id=' . $_GET['id']);
            echo ('<center><p>Le commentaire vient d\'être signalé, merci de votre aide</p></center>');
        }

        else
        {
            $postController->errors();
        }

    }

    elseif ($_GET['action'] == 'AdminConnexion')
    {
        $error = null;
        require 'src/view/front_end/adminConnexionView.php';
    }

    elseif ($_GET['action'] == 'inscription')
    {
        $error = null;
        require 'src/view/front_end/inscriptionUser.php';
    }

    //User inscription public
    elseif ($_GET['action'] == 'userInscription')
    {
        $error = null;

        if (!empty($_POST))
        {
            $validate = true;

            $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
            $_POST['mail'] = htmlspecialchars($_POST['mail']);
            $_POST['pass'] = htmlspecialchars($_POST['pass']);
            $_POST['confirmePass'] = htmlspecialchars($_POST['confirmePass']);

            //Verify pseudo
            if(empty($_POST['pseudo']) || strlen($_POST['pseudo']) > 100 || !preg_match("#^[a-zà-ùA-Z0-9-\s_-]+$#", $_POST['pseudo']))
            {
                $validate = false;
                $error = 5;
            }

            //Verify mail
            if(empty($_POST['mail']) || strlen($_POST['mail']) > 255 || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
            {
                $validate = false;
                $error = 6;
            }

            //Verify passWord
            if(empty($_POST['pass']) || strlen($_POST['pass']) > 255 || !preg_match("#^[a-zA-Z0-9_-]+.{8,}$#", $_POST['pass']))
            {
                $validate = false;
                $error = 7;
            }

            //Confirm pass
            if(empty($_POST['pass']) || ($_POST['pass'] !== $_POST['confirmePass']))
            {
                $validate = false;
                $error = 8;
            }

            if($validate)
            {
                if (empty($userController->pseudoExist($_POST['pseudo'])) && empty($userController->mailExist($_POST['mail'])))
                {
                    $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);

                    $userController->addUser(htmlspecialchars($_POST['pseudo']), htmlspecialchars($_POST['mail']), htmlspecialchars($_POST['pass']));

                    header('Location: index.php?action=AdminConnexion');
                }
                else {
                    $error = 9;
                }
            }
        }

        switch ($error)
        {
            case 5:
            $error = '* Pseudo invalide';
            break;

            case 6:
            $error = '* Mail invalide';
            break;

            case 7:
            $error = '* Mot de passe invalide';
            break;

            case 8:
            $error = '* Confirmez à nouveau votre mot de passe';
            break;

            case 9:
            $error = '* Ce pseudo ou cette adresse mail est déjà utilisé(e)';
            break;
        }

        require 'src/view/front_end/inscriptionUser.php';
    }

    //User connection
    elseif ($_GET['action'] == 'connectUser')
    {
        if (!empty($_POST))
        {
            $validate = true;
            $error = null;

            //verify if empty fields
            if (empty($_POST['pseudo']) || empty($_POST['pass']))
            {
                $erreur = 1;
                $validate = false;
            }

            //Verify length of strings
            if (strlen($_POST['pseudo']) > 100 || strlen($_POST['pass']) > 255)
            {
                $error = 2;
                $validate = false;
            }

            if ($validate)
            {
                $user = $userController->userConnect($_POST['pseudo']);

                if (!$user)
                {
                    $error = 3;
                }

                else
                {
                    $passVerify = password_verify($_POST['pass'], $user['pass']);

                    if($passVerify)
                    {
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['pseudo'] = $user['pseudo'];
                        $_SESSION['user_role'] = $user['user_role'];

                        if($_SESSION['user_role'] == 2)
                        {
                            header('Location: index.php?action=Admin');
                        }
                        else
                        {
                            header('Location: index.php?action=Accueil');
                        }
                    }

                    else
                    {
                        $error = 4;
                    }
                }
            }
        }

        switch ($error)
        {
            case 1:
            $error = '* Veuillez renseigner votre pseudo';
            break;

            case 2:
            $error = '* Veuillez renseigner votre mot de passe';
            break;

            case 3:
            $error = '* Pseudo invalide';
            break;

            case 4:
            $error = '* Mot de passe invalide';
            break;
        }

        require 'src/view/front_end/adminConnexionView.php';
    }

    //Disconnect user
    elseif ($_GET['action'] == 'discUser')
    {
        $userController->disconnectUser();

        header('Location: index.php?action=Accueil');
    }

    /*---------------------------
    1. post's actions
    ---------------------------*/

    elseif ($_GET['action'] == 'AddPostAdmin')
    {
        $countPosts = $postController->nbPost();
        $countComs = $commentController->nbCom();
        $countUsers = $userController->nbUsers();
        $countReport = $commentController->nbReported();

        require 'src/view/back_end/adminPost.php';
    }

    elseif ($_GET['action'] == 'addPost')
    {
        //Admin session action
        if(!empty($_POST['title']) && !empty($_POST['content']))
        {
            $postController->addPost(htmlspecialchars($_POST['title']), htmlspecialchars($_POST['content']));
        }
        else
        {
            $postController->errors();
        }

        header('Location: index.php?action=postAdmin');

    }

    elseif ($_GET['action'] == 'deletePost')
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $postController->deletePost($_GET['id']);
            header('Location: index.php?action=postAdmin');
        }
        else
        {
            $postController->errors();
        }
    }

    //Update post view
    elseif ($_GET['action'] == 'postUpdate')
    {
        if(empty($_SESSION) || $_SESSION['user_role'] == 1)
        {
            header('Location: index.php?action=Accueil');
        }

        else
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $post = $postController->getPost($_GET['id']);

            require 'src/view/back_end/adminUpdatePostView.php';
        }
    }

    //Update post
    elseif ($_GET['action'] == 'updatePost')
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            if(!empty($_POST['content']) && !empty($_POST['title']))
            {
                $postController->updatePost($_GET['id'], htmlspecialchars($_POST['title']), html_entity_decode($_POST['content']));
            }
            else
            {
                $postController->errors();
            }
        }
        else
        {
            $postController->errors();
        }
        header('Location: index.php?action=postViewAdmins&id=' . $_GET['id']);
    }

    //Liste of all posts admin page
    elseif ($_GET['action'] == 'postAdmin')
    {
        if($_SESSION['user_role'] == 2)
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            $Posts = $postController->post();

            require 'src/view/back_end/listPostAdminView.php';
        }
    }

    /*---------------------------
    2. comment's actions
    ---------------------------*/

    //Add comment
    elseif ($_GET['action'] == 'addComment')
    {
        if(isset($_SESSION['pseudo']) && isset($_SESSION['id']))
        {
            if(isset($_GET['id']) && $_GET['id'] > 0)
            {
                $user_id = $_SESSION['id'];

                if(!empty($_POST['comment']))
                {
                    $commentController->newComment($_GET['id'], $user_id, htmlspecialchars($_POST['comment']));
                }
            }
        }

        header('Location: index.php?action=listComments&id=' . $_GET['id']);
    }

    //Delete comment
    elseif ($_GET['action'] == 'deleteCom')
    {
        if(isset($_SESSION['id']) && $_SESSION['id'] > 0)
        {
            if($_SESSION['user_role'] == 2)
            {
                $commentController->deleteCom($_GET['id']);

                header('Location: index.php?action=reportList');
            }

            elseif($_SESSION['user_role'] == 1)
            {
                $commentController->deleteCom($_GET['id']);

                header('Location: index.php?action=userReportList');
            }
        }

        else
        {
            $postController->errors();
        }

    }

    //Update comment view
    elseif ($_GET['action'] == 'commentUpdate')
    {
        if(isset($_SESSION))
        {
            if($_SESSION['user_role'] == 2){
                $countPosts = $postController->nbPost();
                $countComs = $commentController->nbCom();
                $countUsers = $userController->nbUsers();
                $countReport = $commentController->nbReported();
                $Comment = $commentController->getOne($_GET['id']);
            }
            elseif ($_SESSION['user_role'] == 1)
            {
                $user = $userController->getOneUser($_SESSION['id']);
                $Comments = $commentController->getComUser($_GET['id']);
                $user_report = $userController->getUserReport($_SESSION['id']);
            }

            require 'src/view/back_end/adminEditComment.php';
        }

        else
        {
            header('Location: index.php?action=Accueil');
        }

    }

    //Update comment
    elseif ($_GET['action'] == 'updateComment')
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            if(!empty($_POST['comment']))
            {
                $commentController->updateCom($_GET['id'], htmlspecialchars(($_POST['comment'])));
            }
        }
        else
        {
            $postController->errors();
        }

        header('Location: index.php?action=signleCom&id=' .$_GET['id']);
    }

    elseif ($_GET['action'] == 'adminCom')
    {
        if($_SESSION['user_role'] == 2)
        {
            $Comments = $commentController->allCom();
            $countComs = $commentController->nbCom();
            $countPosts = $postController->nbPost();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            require 'src/view/back_end/adminCommentList.php';
        }
    }

    elseif ($_GET['action'] == 'userCom')
    {
        if($_SESSION['user_role'] == 1)
        {
            if (isset($_SESSION['id']) && $_SESSION['id'] > 0)
            {
                $user = $userController->getOneUser($_SESSION['id']);
                $Comments = $commentController->getComUser($_GET['id']);
                $user_report = $userController->getUserReport($_SESSION['id']);

                require 'src/view/back_end/userComList.php';
            }

            else
            {
                $postController->errors();
            }
        }

    }

    //Get signle post admin à revoir
    elseif ($_GET['action'] == 'signleCom')
    {
        if(empty($_SESSION))
        {
            header('Location: index.php?action=Accueil');
        }

        elseif ($_SESSION['user_role'] == 2)
        {
            $countComs = $commentController->nbCom();
            $countPosts = $postController->nbPost();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $Comment = $commentController->getOne($_GET['id']);
        }

        elseif ($_SESSION['user_role'] == 1)
        {
            $Comment = $commentController->getOne($_GET['id']);
            $user = $userController->getOneUser($_SESSION['id']);
            $Comments = $commentController->getComUser($_GET['id']);
            $user_report = $userController->getUserReport($_SESSION['id']);
        }

        require 'src/view/back_end/adminSingleCom.php';
    }

    //Admin reported comment list view
    elseif ($_GET['action'] == 'reportList')
    {
        if(empty($_SESSION) || $_SESSION['user_role'] == 1)
        {
            header('Location: index.php?action=Accueil');
        }

        elseif($_SESSION['user_role'] == 2)
        {
            $countComs = $commentController->nbCom();
            $countPosts = $postController->nbPost();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $report = $commentController->getAllReported();

            require 'src/view/back_end/adminReportedCom.php';
        }
    }

    elseif ($_GET['action'] == 'userReportList')
    {
        if($_SESSION['user_role'] == 1)
        {
            if (isset($_SESSION['id']) && $_SESSION['id'] > 0)
            {
                $user = $userController->getOneUser($_SESSION['id']);
                $report = $commentController->getUserReportedCom($_GET['id']);
                $user_report = $userController->getUserReport($_SESSION['id']);

                require 'src/view/back_end/userReportList.php';
            }

            else
            {
                $postController->errors();
            }
        }
    }

    //Validate reported comment
    elseif ($_GET['action'] == 'validateCom')
    {
        if($_SESSION['user_role'] == 2)
        {

            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $validCom = $commentController->validCom($_GET['id']);
            }

            else
            {
                $postController->errors();
            }

            header('Location: index.php?action=reportList');
        }
    }

    /*---------------------------
    3. Admin's actions
    ---------------------------*/

    elseif ($_GET['action'] == 'Admin')
    {
        if(empty($_SESSION) || $_SESSION['user_role'] == 1)
        {
            header('Location: index.php?action=Accueil');
        }

        else
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();

            $Posts = $postController->adminPost();
            $Comments = $commentController->lastCom();
            $Users = $userController->listUsers();
            $report = $commentController->getReportedCom();

            require 'src/view/back_end/AdminHomeView.php';
        }
    }

    elseif ($_GET['action'] == 'postViewAdmins')
    {
        if(empty($_SESSION) || $_SESSION['user_role'] == 1)
        {
            header('Location: index.php?action=Accueil');
        }

        else
        {
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $post = $postController->getPost($_GET['id']);
                $Comments = $commentController->getComAdmin($_GET['id']);
                $countPosts = $postController->nbPost();
                $countComs = $commentController->nbCom();
                $countUsers = $userController->nbUsers();
                $countReport = $commentController->nbReported();
            }

            else
            {
                $postController->errors();
            }

            require 'src/view/back_end/adminPostView.php';
        }
    }

    elseif ($_GET['action'] == 'listUsers')
    {
        if(empty($_SESSION) || $_SESSION['user_role'] == 1)
        {
            header('Location: index.php?action=Accueil');
        }

        else
        {
            $countPosts = $postController->nbPost();
            $countComs = $commentController->nbCom();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $Users = $userController->allUsers();

            require 'src/view/back_end/adminListUsers.php';
        }
    }

    elseif ($_GET['action'] == 'singleUser')
    {
        if($_SESSION['user_role'] == 2){
            $countComs = $commentController->nbCom();
            $countPosts = $postController->nbPost();
            $countUsers = $userController->nbUsers();
            $countReport = $commentController->nbReported();
            $user = $userController->getOneUser($_GET['id']);
            $user_report = $userController->getUserReport($_GET['id']);

            require 'src/view/back_end/adminSingleUser.php';
        }

        else
        {
            header('Location: index.php?action=Accueil');
        }
    }

    elseif ($_GET['action'] == 'userInfos')
    {
        if($_SESSION['user_role'] == 1){
            $user = $userController->getOneUser($_SESSION['id']);
            $user_report = $userController->getUserReport($_SESSION['id']);

            require 'src/view/back_end/adminSingleUser.php';
        }

        elseif(empty($_SESSION) || $_SESSION['user_role'] == 2)
        {
            header('Location: index.php?action=Accueil');
        }
    }

    elseif ($_GET['action'] == 'deleteUser')
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {

            $userController->deleteU($_GET['id']);

            if($_SESSION['user_role'] == 2)
            {
                header('Location: index.php?action=listUsers');
            }
            elseif ($_SESSION['user_role'] == 1)
            {
                $userController->disconnectUser();
                header('Location: index.php?action=Accueil');
            }
        }
        else
        {
            $postController->errors();
        }
    }
}

else
{
    $Posts = $postController->listPosts();
    $Comments = $commentController->lastCom();

    require 'src/view/front_end/indexView.php';
}
