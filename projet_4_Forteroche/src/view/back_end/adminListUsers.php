<?php $title= 'Jean Forteroche, liste des utilisateurs'; ?>

<?php  ob_start(); ?>

<!-- <article class="blocAdmin"> -->
    <header class="titre">
        <h4>
            <?= $countUsers; ?> utilisateurs
        </h4>
    </header>

    <div class="content">
        <article class="articleComment">
            <?php foreach ($Users as $user): /*var_dump($data)*/?>
                <a href="index.php?action=singleUser&id=<?= $user->id()?>">
                    <div class="allComments">
                        <header class="titreh3">
                            <p>
                                <?= htmlspecialchars($user->pseudo()); ?>
                            </p>
                        </header>

                        <p>
                            inscrit le : <?= htmlspecialchars($user->user_date()); ?>
                            <br>

                            <?= nl2br(htmlspecialchars($user->mail())); ?>
                        </p>

                        <p>
                            <?= htmlspecialchars($user->num_com()); ?> commentaires posté
                        </p>

                        <div class="actions">
                            <button type="button" name="delete" class="button3"> <a href="index.php?action=deleteUser&amp;id=<?= $user->id()?>">Supprimer le compte <i class="fas fa-trash-alt"></i></a></button>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </article>
    </div>
<!-- </article> -->

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
