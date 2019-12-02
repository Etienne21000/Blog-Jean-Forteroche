<?php $title = 'Jean Forteroche, commentaire'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
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
            <?= html_entity_decode(htmlspecialchars($Comment->comment())); ?>
        </p>

        <div class="actions">
            <?php if($_SESSION['user_role'] == 2): ?>
                <a class="button2 validate" href="index.php?action=validateCom&amp;id=<?= $Comment->id(); ?>">Valider <i class="fas fa-check-circle"></i></a>
            <?php endif; ?>

            <?php if($Comment->pseudo() == $_SESSION['pseudo']): ?>
                <a class="button1 update" href="index.php?action=commentUpdate&amp;id=<?= $Comment->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a>
            <?php endif; ?>

            <?php if($Comment->user_id() == $_SESSION['id'] || $_SESSION['user_role'] == 2): ?>
                <a class="button3 delete" href="index.php?action=deleteCom&amp;id=<?= $Comment->id()?>">Supprimer <i class="fas fa-trash-alt"></i></a>
            <?php endif; ?>
        </div>

    </article>

</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
