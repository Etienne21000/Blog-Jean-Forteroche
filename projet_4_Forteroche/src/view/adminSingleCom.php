<?php $title = 'Jean Forteroche, commentaire'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
        <a href="index.php?action=reportList"> <i class="fas fa-arrow-circle-left"></i> retour</a>
        <!-- <a href="index.php?action=adminCom"> <i class="fas fa-arrow-circle-left"></i> retour</a> -->
    <article class="commentAdmin">
        <header class="titre">
            <h3>
                <?= htmlspecialchars($Comment->pseudo()); ?>
            </h3>
            <p id="date">
                <?= 'Commentaire posté le : ' . htmlspecialchars($Comment->comment_date()); ?>
            </p>
        </header>

        <p>
            <?= html_entity_decode($Comment->comment()); ?>
        </p>

        <div class="actions">
            <button type="button" name="update" class="button1"><a href="index.php?action=commentUpdate&amp;id=<?= $Comment->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
            <button type="button" name="delete" class="button3"> <a href="index.php?action=deleteCom&amp;id=<?= $Comment->id()?>">Supprimer <i class="fas fa-trash-alt"></i></a></button>
        </div>

    </article>

</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
