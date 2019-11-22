<?php $title = 'Jean Forteroche, utilisateur'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
    <!-- <a href="index.php?action=listUsers"> <i class="fas fa-arrow-circle-left"></i> retour</a> -->
    <article class="commentAdmin">
        <header class="titre">
            <h3>
                <?= htmlspecialchars($user->pseudo()); ?>
            </h3>
        </header>

        <p>
            <?= 'identifiant : ' . htmlspecialchars($user->id()); ?>
        </p>

        <p>
            <?=  'inscrit depuit le : ' . htmlspecialchars($user->user_date()); ?>
        </p>

        <p>
            <?=  'Role : ' . htmlspecialchars($user->user_slug()); ?>
        </p>

        <p>
            <?= htmlspecialchars($user->num_com()); ?> commentaires posté
        </p>

        <div class="actions">
            <button type="button" name="delete" class="button3"> <a href="index.php?action=deleteUser&amp;id=<?= $user->id(); ?>">Supprimer le compte <i class="fas fa-trash-alt"></i></a></button>
        </div>

    </article>

</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
