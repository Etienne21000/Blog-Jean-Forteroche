<?php $title= 'Jean Forteroche, Administrateur commentaires'; ?>
<!-- mauvaise version -->
<?php  ob_start(); ?>

<section class="general">
    <!-- <article class="article"> -->
    <header class="titre">
        <h3>
            <?= $countComs; ?> commentaires
        </h3>
    </header>

    <!-- </article> -->

    <article class="articleComment">
        <?php foreach ($Comments as $data): /*var_dump($data)*/?>
            <a href="index.php?action=listComments&id=<?= $data->post_id()?>">
                <div class="allComments">
                    <header class="titreh3">
                        <p>
                            <?= htmlspecialchars($data->author()); ?>
                        </p>
                    </header>

                    <p>
                        publié le : <?php echo htmlspecialchars($data->comment_date()); ?>
                        <br>

                        <?= nl2br(htmlspecialchars($data->comment())); ?>
                    </p>

                    <div class="icons">
                        <a href="index.php?action=deleteCom&amp;id=<?= $data->id() ?>" title="Supprimer"><i class="fas fa-times"></i></a>
                        <a href="#update" class="js-update" title="Mettre à jour"><i class="fas fa-comment-dots"></i></a>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </article>

    <a href="index.php?action=listPosts">Retour à l'accueil</a>
</section>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/template.php'; ?>
