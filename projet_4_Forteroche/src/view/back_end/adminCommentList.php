<?php $title= 'Jean Forteroche, liste des commentaires postés'; ?>

<?php  ob_start(); ?>

<!-- <article class="blocAdmin"> -->
<header class="titre">
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
</header>

<div class="content">
    <?php if($_SESSION['user_role'] == 2): ?>
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
                                <button type="button" name="update" class="button1"><a href="index.php?action=commentUpdate&amp;id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
                            <?php endif; ?>
                            <button type="button" name="report" class="button3"> <a href="index.php?action=reportComment&id=<?= $data->id(); ?>">Signaler <i class="fas fa-trash-alt"></i></a></button>
                        </div>
                    </div>
                </a>
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
                                <button type="button" name="update" class="button1"><a href="index.php?action=commentUpdate&amp;id=<?= $data->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a></button>
                            <?php endif; ?>
                            <button type="button" name="report" class="button3"> <a href="index.php?action=reportComment&id=<?= $data->id(); ?>">Signaler <i class="fas fa-trash-alt"></i></a></button>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
