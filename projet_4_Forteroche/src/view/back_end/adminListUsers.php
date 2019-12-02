<?php $title= 'Jean Forteroche, liste des utilisateurs'; ?>

<?php  ob_start(); ?>

<!-- <article class="blocAdmin"> -->
<header class="titre">
    <h4>
        <?= $countUsers; ?> utilisateurs
    </h4>
</header>

<div class="content">
    <article class="articleComment">
        <?php foreach ($Users as $user): /*var_dump($data)*/?>
            <div class="allComments">
                <header class="titreh3">
                    <p>
                        <a href="index.php?action=singleUser&id=<?= $user->id(); ?>">
                            <?= htmlspecialchars($user->pseudo()); ?>
                        </a>
                    </p>
                </header>

                <p>
                    inscrit le : <?= htmlspecialchars($user->user_date()); ?>
                    <br>

                    <?= nl2br(htmlspecialchars($user->mail())); ?>
                </p>

                <p>
                    <?= htmlspecialchars($user->num_com()); ?> commentaires posté
                </p>

                <div class="actions">
                    <a class="button3 delete" href="index.php?action=deleteUser&amp;id=<?= $user->id()?>">Supprimer le compte <i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </article>
</div>
<!-- </article> -->

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
