<?php

$_SESSION['prenom']='Jean';
$_SESSION['nom']='Forteroche';

setcookie('pseudo', 'jeanF', time() + 30*24*3600, null, null, false, true);
setcookie('pays', 'France', time() + 30*24*3600, null, null, false, true);
?>

<!DOCTYPE HTML>
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
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"> -->
</head>

<header class="top">
    <div class="menu_ham">
        <span></span>
    </div>

    <div class="menu nav">
        <!-- <a href="/">Le blog</a> -->
        <a href="/index.php?action=Accueil"> Le blog</a>
        <a href="/index.php?action=post">Les articles</a>
        <!-- <a href="indexTest.php?action=post">Les articles</a> -->
        <a href="/index.php?action=AdminConnexion">Connexion</a>
        <a href="/index.php?action=inscription">Inscription</a>
        <!-- <a href="/index.php?action=Admin"> Admin</a> -->
    </div>

    <div id="ID_Utilisateur">
        <a href="/index.php?action=Admin">
            <i class="fas fa-user-edit"></i>
            <?php
            if(isset($_SESSION['prenom']) && isset($_SESSION['nom']))
            {
                echo  $_SESSION['prenom'] .' ' . $_SESSION['nom'];
            }
            else {
                echo 'se connecter';
            }
            ?>
        </a>
    </div>
</header>

<body>

    <?= $content?>

    <footer>
        <p> COPYRIGHT </p>
        <script src="/src/public/js/ajax.js" type="text/javascript"></script>
        <script src="/src/public/js/menu.js" type="text/javascript"></script>
        <script src="/src/public/js/formulaire.js" type="text/javascript"></script>
        <script src="/src/public/js/transitions.js" type="text/javascript"></script>
        <script src="/src/public/js/main.js" type="text/javascript"></script>
        <!-- <script src="public/js/transition_header.js" type="text/javascript"></script> -->
    </footer>
</body>
</html>