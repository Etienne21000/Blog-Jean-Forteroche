<?php $title= 'Jean Forteroche, liste des commentaires postés'; ?>

<?php  ob_start(); ?>

<article class="titre">
    <h4>
        <?php if($_SESSION['user_role'] == 2){
            echo $countComs . ' commentaires';
        }
        elseif($_SESSION['user_role'] == 1)
        {
            echo $user->num_com() . ' commentaires postés';
        }
        ?>
    </h4>
</article>

<div class="content">
    <?php if($_SESSION['user_role'] == 2): ?>
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
                            <a href="index.php?action=signleCom&id=<?= $data->id()?>">Voir le commentaire</a>
                        </p>

                        <div class="actions">
                            <?php if($data->pseudo() == $_SESSION['pseudo']): ?>
                                <a class="button1 update" href="index.php?action=postUpdate&amp;id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a>
                            <?php endif; ?>
                            <a class="button3 report" href="index.php?action=reportComment&id=<?= $data->id(); ?>">Signaler <i class="fas fa-exclamation"></i></a>
                        </div>
                    </div>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>
    <?php if($_SESSION['user_role'] == 1): ?>
        <article class="articleComment">
            <?php foreach ($Comments as $data): ?>
                <a href="index.php?action=signleCom&id=<?= $data->id()?>">
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
                            <?php if($data->pseudo() == $_SESSION['pseudo']): ?>
                                <a class="button1 update" href="index.php?action=postUpdate&amp;id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a>
                            <?php endif; ?>
                            <a class="button3 report" href="index.php?action=reportComment&id=<?= $data->id(); ?>">Signaler <i class="fas fa-exclamation"></i></a>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require_once 'src/public/templateAdmin.php'; ?>
