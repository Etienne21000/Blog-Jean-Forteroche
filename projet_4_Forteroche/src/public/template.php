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
        <?php if(!isset($_SESSION['id']) && !isset($_SESSION['pseudo'])):?>
            <a href="/index.php?action=AdminConnexion">Connexion</a>
            <a href="/index.php?action=inscription">Inscription</a>
        <?php endif; ?>
        <?php if(isset($_SESSION['id']) && isset($_SESSION['pseudo'])): ?>
            <a href="/index.php?action=discUser">Déconnexion</a>
        <?php endif;?>
    </div>

    <div id="ID_Utilisateur">
        <!-- <a href="/index.php?action=Admin"> -->
        <i class="fas fa-user-edit"></i>
        <?php
        if(isset($_SESSION['pseudo']) && isset($_SESSION['id']))
        {
            ?>
            <?php if($_SESSION['user_role'] == 2) {?>
                <a href="/index.php?action=Admin"> <?php echo  $_SESSION['pseudo']; ?> </a>
            <?php }
            elseif ($_SESSION['user_role'] == 1) {?>
                <a href="/index.php?action=userInfos"> <?= $_SESSION['pseudo']?></a>
                <?php
            }
            ?>
            <?php
        }
        else
        {
            ?>
            <a href="index.php?action=AdminConnexion">Connexion</a>
            <?php
        }
        ?>
        <!-- </a> -->
    </div>
</header>

<body>


    <?= $content?>


    <footer>
        <p> COPYRIGHT </p>
        <!-- <script src="/src/public/js/ajax.js" type="text/javascript"></script> -->
        <script src="/src/public/js/menu.js" type="text/javascript"></script>
        <script src="/src/public/js/transitionsAdmin.js" type="text/javascript"></script>
        <!-- <script src="/src/public/js/menuAdmin.js" type="text/javascript"></script> -->
        <script src="/src/public/js/formulaire.js" type="text/javascript"></script>
        <script src="/src/public/js/transitions.js" type="text/javascript"></script>
        <script src="/src/public/js/main.js" type="text/javascript"></script>
        <script src="/src/public/js/tinyMce/tinymce.min.js" type="text/javascript"></script>
        <script src="/src/public/js/wysiwyg.js" type="text/javascript"></script>
    </footer>
</body>
</html>
