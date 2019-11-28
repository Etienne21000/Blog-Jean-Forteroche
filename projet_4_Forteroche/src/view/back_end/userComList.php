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
            <a href="index.php?action=signleCom&id=<?= $data->id(); ?>">
                <?php/* echo var_dump($data); */?>
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
                        <button type="button" name="delete" class="button3"> <a href="index.php?action=deleteCom&amp;id=<?= $data->id()?>">Supprimer <i class="fas fa-trash-alt"></i></a></button>
                    </div>

                </div>
            </a>

        <?php endforeach; ?>
    </article>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
