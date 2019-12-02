<?php $title= 'Jean Forteroche, liste des articles postés'; ?>

<?php  ob_start(); ?>

<article class="titre">
    <h4>
        <?= $countPosts; ?> articles postés
    </h4>
</article>

<div class="content">
    <article class="articleComment">
        <?php foreach ($Posts as $data): ?>
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

                <?= substr(html_entity_decode(htmlspecialchars($data->content())),0,250) . '...'; ?>

                <p class="continu">
                    <a href="index.php?action=postViewAdmins&amp;id=<?= $data->id(); ?>">Lire la suite...</a>
                </p>

                <p>
                    Cet article à été commenté <?= htmlspecialchars($data->num_com()); ?> fois.
                </p>

                <div class="actions">
                    <a class="button1 update" href="index.php?action=postUpdate&amp;id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a>
                    <a class="button3 delete" href="index.php?action=deletePost&amp;id=<?= $data->id(); ?>">Supprimer <i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        <?php endforeach; ?>

    </article>
</div>

<?php $content = ob_get_clean(); ?>

<?php require_once 'src/public/templateAdmin.php'; ?>
