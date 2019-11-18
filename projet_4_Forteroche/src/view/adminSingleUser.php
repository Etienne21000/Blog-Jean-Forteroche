<?php $title = 'Jean Forteroche, utilisateur'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
    <a href="index.php?action=listUsers"> <i class="fas fa-arrow-circle-left"></i> retour</a>
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
            <?=  'inscrit le : ' . htmlspecialchars($user->user_date()); ?>
        </p>

        <p>
            <?=  'Role : ' . htmlspecialchars($user->user_role()); ?>
        </p>

        <p>
            <?=  'Role : ' . htmlspecialchars($user->slug()); ?>
        </p>

        <p>
            <?= htmlspecialchars($user->num_com()); ?> commentaires posté
        </p>

        <div class="actions">
            <button type="button" name="update" class="button1"><a href="index.php?action=commentUpdate&amp;id=<?php /*echo $user->id(); */?>">Editer <i class="fas fa-pen-nib"></i></a></button>
            <button type="button" name="delete" class="button3"> <a href="index.php?action=deleteCom&amp;id=<?php /*echo $user->id()*/?>">Supprimer <i class="fas fa-trash-alt"></i></a></button>
        </div>

    </article>

</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
