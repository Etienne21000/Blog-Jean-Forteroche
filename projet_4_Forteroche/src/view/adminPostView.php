<?php $title= 'Jean Forteroche, commentaires'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
    <a href="index.php?action=postAdmin"> <i class="fas fa-arrow-circle-left"></i> retour</a>

    <article class="articleAdmin">
        <header class="titre">
            <h3>
                <?= htmlspecialchars($post->title()); ?>
            </h3>
            <p id="date">
                <?= 'Billet créé le : ' . htmlspecialchars($post->creation_date()); ?>
            </p>
        </header>

        <div class="actions">
            <button type="button" name="update" class="button1"><a href="index.php?action=postUpdate&id=<?= $post->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
            <button type="button" name="delete" class="button3"> <a href="index.php?action=">Supprimer <i class="fas fa-trash-alt"></i></a></button>
        </div>

        <p>
            <?= nl2br(htmlspecialchars($post->content())); ?>
        </p>
    </article>

</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
