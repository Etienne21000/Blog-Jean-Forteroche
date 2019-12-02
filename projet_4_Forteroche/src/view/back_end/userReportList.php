<?php $title= 'Jean Forteroche, commentaires signalés membres'; ?>

<?php  ob_start(); ?>

<header class="titre">
    <h4>
        <?= $user_report->num_com() . ' commentaires signalés'; ?>
    </h4>
</header>

<div class="content">
    <article class="articleComment">
        <?php foreach ($report as $data): ?>
                <div class="allComments">
                    <header class="titreh3">
                        <p>
                            <?= htmlspecialchars($data->pseudo()); ?>
                        </p>
                    </header>

                    <p>
                        publié le : <?php echo htmlspecialchars($data->comment_date()); ?>
                        <br>

                        <?= substr(html_entity_decode(htmlspecialchars($data->comment())),0,50) . '...'; ?>
                    </p>

                    <div class="actions">
                        <a class="button1 update" href="index.php?action=commentUpdate&amp;id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a>
                        <a class="button3 delete" href="index.php?action=deleteCom&amp;id=<?= $data->id(); ?>">Supprimer <i class="fas fa-trash-alt"></i></a>
                    </div>

                </div>
        <?php endforeach; ?>
    </article>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
