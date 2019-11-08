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
                        <em> <?= htmlspecialchars($data->creation_date());  ?></em>
                    </header>

                    <p>
                        <?= substr(nl2br(htmlspecialchars($data->content())),0,300) . '...'; ?>
                    </p>

                    <div class="actions">
                        <button type="button" name="update" class="button1"><a href="index.php?action=postUpdate&id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
                        <button type="button" name="delete" class="button3"> <a href="index.php?action=">Supprimer <i class="fas fa-trash-alt"></i></a></button>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>

    </article>
</div>

<!-- </article> -->

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
