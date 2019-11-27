<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title> <?= $title?> </title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Special+Elite&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/src/public/css/style.css"/>
    <link rel="stylesheet" href="/src/public/faw/css/all.min.css"/>
</head>

<header class="top-Admin">

    <div id="ID_Utilisateur_admin">
        <a href="/index.php?action=Accueil" title="retour à l'accueil du site">
            <i class="fas fa-user-edit"></i>
            <?php
            if(isset($_SESSION['pseudo']) && isset($_SESSION['id']))
            {
                echo  $_SESSION['pseudo'];
            }
            else {
                echo 'se connecter';
            }
            ?>
        </a>
    </div>
</header>

<body>

    <section class="generalAdmin">

        <header class="titre">
            <h3>
                <a href="index.php?action=Accueil" title="Retour à l'accueil">Bonjour <?php echo  $_SESSION['pseudo']; ?></a>
            </h3>
        </header>

         <div id="contentAdminView">

            <div id="admin_fleche">
                <p>Menu
                    <i class="fas fa-chevron-down" id="fleche_bas_admin"></i>
                    <i class="fas fa-chevron-up" id="fleche_haut_admin"></i>
                </p>
            </div>

            <aside class="asideAdmin">
                <ul id="adminList">
                    <?php if($_SESSION['user_role'] == 2):?>
                        <li class="menuAdmin"><a href="index.php?action=Admin"><i class="fas fa-tachometer-alt"></i>Tableau de bord</a></li>
                        <li class="menuAdmin"><a href="index.php?action=postAdmin"><i class="fas fa-list-ul"></i>Articles  <?= '(' . $countPosts . ')'; ?></a></li>
                        <li class="menuAdmin"><a href="index.php?action=adminCom"><i class="fas fa-list-ul"></i>Commentaires <?= '(' . $countComs . ')';?></a></li>
                        <li class="menuAdmin"><a href="index.php?action=reportList"><i class="fas fa-list-ul"></i>Signalés <?= '(<em id="signalés">' . $countReport . '</em>)';?></a></li>
                        <li class="menuAdmin"><a href="index.php?action=listUsers"><i class="fas fa-list-ul"></i>Utilisateurs <?= '(' . $countUsers . ')'; ?> </a></li>
                    <?php endif; ?>
                    <?php if($_SESSION['user_role'] == 1):?>
                        <li class="menuAdmin"><a href="index.php?action=Accueil"><i class="fas fa-igloo"></i>Accueil</a></li>
                        <li class="menuAdmin"><a href="index.php?action=adminCom"><i class="fas fa-list-ul"></i>Commentaires <?= '(' . $user->num_com() . ')';?></a></li>
                        <li class="menuAdmin"><a href="index.php?action=reportList"><i class="fas fa-list-ul"></i>Signalés <?= '(<em id="signalés">' . $user_report->num_com() . '</em>)';?></a></li>
                    <?php endif;?>
                    <li class="menuAdminDeco"><a href="index.php?action=discUser"><i class="fas fa-power-off"></i> Deconnexion</a></li>
                </ul>
            </aside>

            <div id="blocInfos">
                <?= $content?>
            </div>
        </div>
    </section>

    <footer>
        <p> COPYRIGHT </p>
        <script src="/src/public/js/transitionsAdmin.js" type="text/javascript"></script>
        <script src="src/public/js/tinyMce/tinymce.min.js" type="text/javascript"></script>
        <script src="src/public/js/wysiwyg.js" type="text/javascript"></script>
    </footer>
</body>
</html>
