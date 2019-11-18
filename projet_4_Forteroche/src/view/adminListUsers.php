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
            <?php foreach ($Users as $data): /*var_dump($data)*/?>
                <a href="index.php?action=singleUser&id=<?= $data->id()?>">
                    <div class="allComments">
                        <header class="titreh3">
                            <p>
                                pseudo : <?= htmlspecialchars($data->pseudo()); ?>
                            </p>
                        </header>

                        <p>
                            inscrit le : <?php echo htmlspecialchars($data->user_date()); ?>
                            <br>

                            <?= nl2br(htmlspecialchars($data->mail())); ?>
                        </p>

                        <p>
                            <?= htmlspecialchars($data->num_com()); ?> commentaires posté
                        </p>

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
