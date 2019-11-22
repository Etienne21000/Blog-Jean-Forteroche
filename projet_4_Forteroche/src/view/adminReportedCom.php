<?php $title= 'Jean Forteroche, liste des commentaires signalés'; ?>

<?php  ob_start(); ?>

<header class="titre">
    <h4>
        <?= $countReport; ?> commentaires signalés
    </h4>
</header>

<div class="content">
    <article class="articleComment">
        <?php foreach ($report as $data): ?>
            <a href="index.php?action=signleCom&id=<?=$data->id(); ?>">
                <div class="allComments">
                    <header class="titreh3">
                        <p>
                            <?= htmlspecialchars($data->pseudo()); ?>
                        </p>
                    </header>

                    <p>
                        publié le : <?php echo htmlspecialchars($data->comment_date()); ?>
                        <br>

                        <?= substr(nl2br(html_entity_decode($data->comment())),0,50) . '...'; ?>
                    </p>

                    <div class="actions">
                        <button type="button" name="update" class="button1"><a href="index.php?action=commentUpdate&amp;id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
                        <button type="button" name="validate" class="button2"> <a href="index.php?action=validateCom&amp;id=<?= $data->id(); ?>">Valider <i class="fas fa-check-circle"></i></a></button>
                        <button type="button" name="delete" class="button3"> <a href="index.php?action=deleteCom&amp;id=<?= $data->id()?>">Supprimer <i class="fas fa-trash-alt"></i></a></button>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </article>
</div>
<!-- </article> -->

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
