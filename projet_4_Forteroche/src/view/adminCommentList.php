<?php $title= 'Jean Forteroche, liste des commentaires postés'; ?>

<?php  ob_start(); ?>

<!-- <article class="blocAdmin"> -->
<header class="titre">
    <h4>
        <?= $countComs; ?> Commentaires
    </h4>
</header>

<div class="content">
    <article class="articleComment">
        <?php foreach ($Comments as $data): /*var_dump($data)*/?>
            <a href="index.php?action=signleCom&id=<?= $data->id()?>">
                <div class="allComments">
                    <header class="titreh3">
                        <p>
                            <?php /*htmlspecialchars($data->user_id()); */?>
                            <?= htmlspecialchars($data->pseudo()); ?>
                        </p>
                    </header>

                    <p>

                    publié le : <?php echo htmlspecialchars($data->comment_date()); ?>
                    <br>

                    <?= substr(html_entity_decode($data->comment()),0,50) . '...'; ?>
                </p>

                <div class="actions">
                    <button type="button" name="update" class="button1"><a href="index.php?action=commentUpdate&amp;id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</article>
</div>
<!-- </article> -->

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
