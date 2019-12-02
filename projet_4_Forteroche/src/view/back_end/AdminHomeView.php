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
                <div class="articleBloc2">

                    <p>
                        <?php echo htmlspecialchars($data->title()); ?>
                    </p>

                    <p>
                        <?php echo htmlspecialchars($data->creation_date()); ?>
                    </p>

                    <p class="continu">
                        <a href="index.php?action=listComments&id=<?= $data->id(); ?>"> Voir l'article...</a>
                    </p>
                </div>
        <?php endforeach; ?>
    </div>

    <div class="actions">
        <a class="button1 listPost" href="index.php?action=postAdmin">Liste <i class="fas fa-list"></i></a>
        <a class="button2 addPost" href="index.php?action=AddPostAdmin">Ajouter un article</a>
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
            <a href="index.php?action=signleCom&id=<?= $data->id()?>">
                <div class="commentBloc2">

                    <p>
                        <?= htmlspecialchars($data->pseudo()); ?>
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
        <a class="button1 listCom" href="index.php?action=adminCom">Liste <i class="fas fa-list"></i></a>
    </div>
</article>

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
                        <?= htmlspecialchars($data->pseudo()); ?>
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
        <a class="button1 listComReported" href="index.php?action=reportList">Liste <i class="fas fa-list"></i></a>
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
                        <br>
                        <?= htmlspecialchars($data->mail()); ?>
                        <br>
                        inscrit depuis le :  <?php echo htmlspecialchars($data->user_date()); ?>
                        <br>
                        <?= htmlspecialchars($data->num_com()); ?> commentaires posté
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="actions">
        <a class="button1 listUser" href="index.php?action=listUsers">Liste <i class="fas fa-list"></i></a>
    </div>
</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
