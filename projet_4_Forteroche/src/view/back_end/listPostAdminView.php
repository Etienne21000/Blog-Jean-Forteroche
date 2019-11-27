<?php $title= 'Jean Forteroche, liste des articles postés'; ?>

<?php  ob_start(); ?>

<!-- <article class="blocAdmin"> -->
<header class="titre">
    <h4>
        <?= $countPosts; ?> articles postés
    </h4>
</header>

<div class="content">
    <article class="articleComment">
        <?php foreach ($Posts as $data): ?>
            <a href="index.php?action=postViewAdmins&id=<?= $data->id(); ?>">
                <div class="allComments">
                    <header class="titreh3">
                        <h3>
                            <?= htmlspecialchars($data->title());?>
                        </h3>
                        <em>
                            <?php if($data->edition_date()){
                                echo 'Modifier le ' . htmlspecialchars($data->edition_date());
                            }
                            else {
                                echo 'Créé le ' . htmlspecialchars($data->creation_date());
                            } ?>
                        </em>
                    </header>

                    <!-- <p> -->
                    <?= substr(html_entity_decode($data->content(), ENT_HTML5, 'UTF-8'),0,300) . '...'; ?>
                    <!-- </p> -->
                    <p>
                        Cet article à été commenté <?= htmlspecialchars($data->num_com()); ?> fois.
                    </p>

                    <div class="actions">
                        <button type="button" name="update" class="button1"><a href="index.php?action=postUpdate&amp;id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
                        <button type="button" name="delete" class="button3"> <a href="index.php?action=deletePost&amp;id=<?= $data->id();?>">Supprimer <i class="fas fa-trash-alt"></i></a></button>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>

    </article>
</div>

<!-- </article> -->

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
