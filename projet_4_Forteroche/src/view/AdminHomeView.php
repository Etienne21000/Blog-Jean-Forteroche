<?php $title= 'Jean Forteroche, tableau de bord'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
    <header class="titre">
        <h4>
            <?= $countPosts; ?> articles postés
        </h4>
    </header>

    <div class="content">
        <?php foreach ($Posts as $data): ?>
            <a href="index.php?action=postViewAdmins&id=<?= $data->id(); ?>">
                <div class="articleBloc2">

                    <p>
                        <?php echo htmlspecialchars($data->title()); ?>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($data->creation_date()); ?>
                    </p>

                    <p id="continu">
                        <a href="index.php?action=listComments&id=<?= $data->id(); ?>">Voir l'article...</a>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="actions">
        <button type="button" name="listPost" class="button1"><a href="index.php?action=postAdmin">Liste <i class="fas fa-list"></i></a></button>
        <button type="button" name="addPost" class="button2"> <a href="index.php?action=AddPostAdmin">Ajouter un article</a></button>
    </div>
</article>

<article class="blocAdmin">
    <header class="titre">
        <h4>
            <?= $countComs; ?> commentaires publiés
        </h4>
    </header>

    <div class="content">
        <?php foreach ($Comments as $data): ?>
            <a href="index.php?action=listComments&id=<?= $data->id()?>">
                <div class="commentBloc2">

                    <p>
                        <?php echo htmlspecialchars($data->author()); ?>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($data->comment_date()); ?>
                    </p>

                    <p>
                        <?= substr(nl2br(htmlspecialchars($data->comment())),0,20) . '...'; ?>
                    </p>

                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="actions">
        <button type="button" name="listCom" class="button1"><a href="index.php?action=adminCom">Liste <i class="fas fa-list"></i></a></button>
        <button type="button" name="editCom" class="button2"><a href="">signalés</a></button>
    </div>
</article>

<!-- reported comments -->
<article class="blocAdmin">
    <header class="titre">
        <h4>
            <?php echo $countReport; ?> commentaires signalés
        </h4>
    </header>

    <div class="content">
        <?php foreach ($report as $data): ?>
            <a href="index.php?action=reportList">
                <div class="commentBloc2">

                    <p>
                        <?= htmlspecialchars($data->author()); ?>
                    </p>

                    <p>
                        <?= htmlspecialchars($data->comment_date()); ?>
                    </p>

                    <p>
                        <?= substr(nl2br(htmlspecialchars($data->comment())),0,20) . '...'; ?>
                    </p>

                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="actions">
        <button type="button" name="listComReported" class="button1"><a href="index.php?action=reportList">Liste <i class="fas fa-list"></i></a></button>
        <button type="button" name="editCom" class="button2"><a href="">signalés</a></button>
    </div>
</article>

<article class="blocAdmin">
    <header class="titre">
        <h4>
            <?= $countUsers; ?> utilisateurs
        </h4>
    </header>

    <div class="content">
        <?php foreach ($Users as $data): ?>
            <a href="index.php?action=singleUser&id=<?= $data->id(); ?>">
                <div class="userBloc">

                    <p>
                        <?= htmlspecialchars($data->pseudo()); ?>
                    </p>

                    <p>
                        <?= htmlspecialchars($data->mail()); ?>
                    </p>

                    <p>
                        inscrit depuis le :  <?= htmlspecialchars($data->user_date()); ?>
                        <br>
                        <?= htmlspecialchars($data->num_com()); ?> commentaires posté
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="actions">
        <button type="button" name="listUser" class="button1"><a href="index.php?action=listUsers">Liste <i class="fas fa-list"></i></a></button>
        <button type="button" name="editUser" class="button2"><a href="">Modifier</a></button>
    </div>
</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
