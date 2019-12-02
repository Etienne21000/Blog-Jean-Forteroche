<?php $title= 'Jean Forteroche, article'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
    <article class="articleAdmin">
        <header class="titre">
            <h3>
                <?= htmlspecialchars($post->title()); ?>
            </h3>
            <p id="date">
                <?= 'Billet créé le : ' . htmlspecialchars($post->creation_date()); ?>
            </p>
        </header>

        <div class="actions">
            <a class="button1 update" href="index.php?action=postUpdate&id=<?= $post->id(); ?>">Editer <i class="fas fa-pen-nib"></i></a>
            <a class="button3 delete" href="index.php?action=deletePost&id=<?= $post->id(); ?>">Supprimer <i class="fas fa-trash-alt"></i></a>
        </div>

            <?= html_entity_decode($post->content()); ?>
    </article>

    <p>
        <?= htmlspecialchars($post->num_com());?> <a href="">commentaires postés</a>
    </p>

    <article class="commentsPost">

    	<?php foreach ($Comments as $data): ?>
    		<p class="author">

    			<?= htmlspecialchars($data->pseudo()); ?>
    			le
    			<?= htmlspecialchars($data->comment_date()); ?>
    		</p>

    		<div class="comment">
    			<p>
    				<?= nl2br(html_entity_decode(htmlspecialchars($data->comment()))); ?>
    			</p>
                <div class="actions">
                    <a class="button1 signleCom" href="index.php?action=signleCom&id=<?= $data->id()?>">Voir le commentaire </a>
                    <a class="button3 delete" href="index.php?action=reportComment&id=<?= $data->id(); ?>">Signaler <i class="fas fa-trash-alt"></i></a>
                </div>
    		</div>

    	<?php endforeach; ?>

    </article>

</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
