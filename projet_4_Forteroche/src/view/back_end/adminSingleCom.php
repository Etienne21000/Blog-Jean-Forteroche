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
            <?php if($Comment->report() == 1 && $_SESSION['user_role'] == 2): ?>
                <button type="button" name="validate" class="button2"> <a href="index.php?action=validateCom&amp;id=<?= $Comment->id(); ?>">Valider <i class="fas fa-check-circle"></i></a></button>
            <?php endif; ?>
            
            <?php if($Comment->pseudo() == $_SESSION['pseudo']): ?>
                <button type="button" name="update" class="button1"><a href="index.php?action=commentUpdate&amp;id=<?= $Comment->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
            <?php endif; ?>

            <?php if($Comment->user_id() == $_SESSION['id'] || $_SESSION['user_role'] == 2): ?>
                <button type="button" name="delete" class="button3"> <a href="index.php?action=deleteCom&amp;id=<?= $Comment->id()?>">Supprimer <i class="fas fa-trash-alt"></i></a></button>
            <?php endif; ?>
        </div>

    </article>

</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
