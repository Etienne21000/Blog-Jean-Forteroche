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

            require 'src/view/front_end/indexView.php';
        }

        elseif ($_GET['action'] == 'post')
        {
            $Posts = $postController->post();
            // $countPosts = $postController->nbPost();

            require 'src/view/front_end/chapterView.php';
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
            require 'src/view/front_end/postView.php';
        }

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

                    else
                    {
                        throw new Exception("vous n'avez pas remplis tous les champs! (rooter)");
                    }
                }

                else
                {
                    throw new \Exception("impossible de commenter");
                }
            }

            else
            {
                require 'src/view/front_end/inscriptionUser.php';
            }

            header('Location: index.php?action=listComments&id=' . $_GET['id']);
        }

        //Report comment by user revoir la redirection id
        elseif ($_GET['action'] == 'reportComment')
        {
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                $reportedCom = $commentController->reportCom($_GET['id']);

                if($_SESSION['user_role'] == 2)
                {
                    header('Location: index.php?action=adminCom');
                }

                else
                {
                    header('Location: index.php&action=listComments&id=' . $_GET['post_id']);
                }
            }

            else
            {
                throw new \Exception("Impossible de signaler ce commentaire car aucun identifiant de commentaire envoyé (rooter)");
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
            if (!empty($_POST))
            {
                $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
                $_POST['mail'] = htmlspecialchars($_POST['mail']);
                $_POST['pass'] = htmlspecialchars($_POST['pass']);
                $_POST['confirmePass'] = htmlspecialchars($_POST['confirmePass']);
                // $errors = array();


                $validate = true;
                $error = null;

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

                //Verufy passWord
                if(empty($_POST['pass']) || strlen($_POST['pass']) > 255 || !preg_match("#^[a-zA-Z0-9_-]+.{8,}$#", $_POST['pass']))
                {
                    $validate = false;
                    $error = 7;
                }

                //Confirm pass
                if (($_POST['pass'] !== $_POST['confirmePass']))
                {
                    $validate = false;
                    $error = 8;
                }

                if($validate = true)
                {
                    // $hash_pass = $_POST['pass'];
                    if (empty($userController->pseudoExist($_POST['pseudo'])) && empty($userController->mailExist($_POST['mail'])))
                    {
                        $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);

                        $userController->addUser(htmlspecialchars($_POST['pseudo']), htmlspecialchars($_POST['mail']), htmlspecialchars($_POST['pass']));

                        // require 'src/view/front_end/adminConnexionView.php';
                        header('Location: index.php?action=AdminConnexion');
                    }
                    else {
                        $error = 9;
                        // echo '<p>Ce pseudo est déjà utilisé ou le mail est invalide</p>';
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

                //if form is ok validate retunr true
                if ($validate = true)
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

            // header('Location: index.php?action=AdminConnexion');
            require 'src/view/front_end/adminConnexionView.php';
        }

        //Disconnect user
        elseif ($_GET['action'] == 'discUser')
        {
            $userController->disconnectUser();

            header('Location: index.php?action=Accueil');
        }

        /*---------------------------------------------------
        Admin actions with specific acces role = 2
        ----------------------------------------------------*/

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
            $postController->addPost(/*htmlspecialchars($_POST['title']), htmlentities($_POST['content'])*/);
            }
            else
            {
                throw new Exception("vous n'avez pas remplis tous les champs pour poster votre billet! (rooter)");
            }

            header('Location: index.php?action=postAdmin');

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
            header('Location: index.php?action=postAdmin');
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
                    throw new Exception('impossible de mettre à jour le billet');
                }
            }
            else
            {
                throw new Exception('Aucun id de billet envoyé (rooter)');
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

                header('Location: index.php?action=reportList');
            }

            //Update comment view
            elseif ($_GET['action'] == 'commentUpdate')
            {
                if(isset($_SESSION))
                {
                    $countPosts = $postController->nbPost();
                    $countComs = $commentController->nbCom();
                    $countUsers = $userController->nbUsers();
                    $countReport = $commentController->nbReported();
                    $Comment = $commentController->getOne($_GET['id']);

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
                        $commentController->updateCom($_GET['id'], html_entity_decode(($_POST['comment'])));
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

                // A revoir
                elseif ($_SESSION['user_role'] == 1)
                {
                    if (isset($_GET['id']) && $_GET['id'] > 0)
                    {
                        $user = $userController->getOneUser($_SESSION['id']);
                        $Comments = $commentController->getComUser($_GET['id']);
                        $user_report = $userController->getUserReport($_SESSION['id']);

                        header('Location: index.php?action=adminCom&id=' . $_GET['id']);
                        // require 'src/view/back_end/adminCommentList.php';
                    }

                    else
                    {
                        throw new Exception("Aucun identifiant utilisateur ne correspond (rooter)");
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

                    require 'src/view/back_end/adminSingleCom.php';
                }
                // elseif ($_SESSION['user_role'] == 1)
                // {
                //     $user = $userController->getOneUser($_SESSION['id']);
                //     $user_report = $userController->getUserReport($_SESSION['id']);
                //     $Comments = $commentController->allCom();
                //     $Comment = $commentController->getOne($_GET['id']);
                // }
            }

            //Admin reported comment list view
            elseif ($_GET['action'] == 'reportList')
            {
                if(empty($_SESSION) || $_SESSION['user_role'] == 1)
                {
                    header('Location: index.php?action=Accueil');
                }

                // elseif ()
                // {
                //     $Comments = $commentController->allCom();
                //     $user = $userController->getOneUser($_SESSION['id']);
                //     $user_report = $userController->getUserReport($_SESSION['id']);
                // }

                else
                {
                    $countComs = $commentController->nbCom();
                    $countPosts = $postController->nbPost();
                    $countUsers = $userController->nbUsers();
                    $countReport = $commentController->nbReported();
                    $report = $commentController->getAllReported();

                    require 'src/view/back_end/adminReportedCom.php';
                }
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
                    header('Location: index.php?action=Accueil');            }

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
                            throw new Exception("Aucun identifiant de billet ne correspond (rooter)");
                        }
                        // header('Location: index.php?action=Accueil');
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
                    }
                    require 'src/view/back_end/adminSingleUser.php';
                }

                elseif ($_GET['action'] == 'deleteUser')
                {
                    if(isset($_GET['id']) && $_GET['id'] > 0)
                    {
                        $userController->deleteU($_GET['id']);
                        $userController->disconnectUser();

                        header('Location: index.php?action=Accueil');
                    }
                    else
                    {
                        throw new \Exception("impossiblme de supprimer le compte");
                    }
                }

                /*---------------------------
                3. Admin's actions
                ---------------------------*/
            }

            else
            {
                $Posts = $postController->listPosts();
                $Comments = $commentController->lastCom();

                require 'src/view/front_end/indexView.php';
            }
        }
        catch (Exception $e)
        {
            echo '<strong>Erreur</strong> : une erreur s\'est produite : ' . $e->getMessage();
        }
