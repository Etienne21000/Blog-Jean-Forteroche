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

                            <?= substr(nl2br(htmlspecialchars($data->comment())),0,50) . '...'; ?>
                        </p>

                        <!-- <div class="icons">
                            <a href="index.php?action=deleteCom&amp;id=<?php/* $data->id()*/ ?>" title="Supprimer"><i class="fas fa-times"></i></a>
                            <a href="#update" class="js-update" title="Mettre à jour"><i class="fas fa-comment-dots"></i></a>
                        </div> -->
                        <div class="actions">
                            <button type="button" name="update" class="button1"><a href="index.php?action=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
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
