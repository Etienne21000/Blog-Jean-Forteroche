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

<header class="top">
    <div class="menu_ham">
        <span></span>
    </div>

    <div class="menu nav">
        <a href="/index.php?action=Accueil"> Le blog</a>
        <a href="/index.php?action=post">Les articles</a>
        <a href="/index.php?action=AdminConnexion">Connexion</a>
        <a href="/index.php?action=inscription">Inscription</a>
    </div>

    <div id="ID_Utilisateur">
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
            <aside id="asideAdmin">
                <ul id="adminList">
                    <li class="menuAdmin"><a href="index.php?action=Admin"><i class="fas fa-tachometer-alt"></i>Tableau de bord</a></li>
                    <li class="menuAdmin"><a href="index.php?action=postAdmin"><i class="fas fa-list-ul"></i>Articles  <?= '(' . $countPosts . ')'; ?></a></li>
                    <li class="menuAdmin"><a href="index.php?action=adminCom"><i class="fas fa-list-ul"></i>Commentaires <?= '(' . $countComs . ')';?></a></li>
                    <li class="menuAdmin"><a href="index.php?action=reportList"><i class="fas fa-list-ul"></i>Signalés <?= '(<em id="signalés">' . $countReport . '</em>)';?></a></li>
                    <li class="menuAdmin"><i class="fas fa-list-ul"></i>Utilisateurs <?= '(' . $countUsers . ')'; ?> </li>
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
        <script src="/src/public/js/ajax.js" type="text/javascript"></script>
        <script src="/src/public/js/menu.js" type="text/javascript"></script>
        <script src="/src/public/js/formulaire.js" type="text/javascript"></script>
        <script src="/src/public/js/transitions.js" type="text/javascript"></script>
        <script src="/src/public/js/main.js" type="text/javascript"></script>
        <script src="/src/public/js/tinyMce/tinymce.min.js" type="text/javascript"></script>
        <script src="/src/public/js/wysiwyg.js" type="text/javascript"></script>
    </footer>
</body>
</html>
