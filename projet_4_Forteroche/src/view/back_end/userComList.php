<?php $title= 'Jean Forteroche, commentaires membres'; ?>

<?php  ob_start(); ?>

<header class="titre">
    <h4>
        <?= 'Vous avez posté ' . $user->num_com() . ' commentaires postés'; ?>
    </h4>
</header>

<div class="content">
    <article class="articleComment">
        <?php foreach ($Comments as $data): ?>
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

                    <p class="continu">
                        <a href="index.php?action=signleCom&id=<?= $data->id(); ?>">Voir le commentaire</a>
                    </p>

                    <div class="actions">
                        <a class="button3 delete" href="index.php?action=deletePost&amp;id=<?= $data->id(); ?>">Supprimer <i class="fas fa-trash-alt"></i></a>
                    </div>

                </div>
        <?php endforeach; ?>
    </article>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
