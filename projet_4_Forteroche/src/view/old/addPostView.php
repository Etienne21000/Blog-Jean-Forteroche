<?php $title= 'Jean Forteroche, commentaires'; ?>

<?php  ob_start(); ?>

<section class="general">
	<article class="article">
		<header class="titre">
            <h4>Mettre à jour l'article</h4>
        </header>

        <aside id="update" role="dialog" aria-labelledby="titre-update">
        	<article id="update-wrapper">
        		<header class="titre titre-update">
        			<h4>Mettre à jour l'article</h4>
        		</header>
                <?php foreach ($post as $data): ?>

        			<form action="index.php?action=updatepost&amp;id=<?= $data->id(); ?>" method="POST">
        				<p>
        					Titre : <?= $data->title(); ?>
        					<br>
        					Article à modifier : <?= substr(nl2br(htmlspecialchars($data->content())), 0, 100) . '...'; ?>
        				</p>
        			<?php endforeach; ?>
        			<p>
        				<label for="form-comment">message</label>
        				<br>
        				<textarea type="text" name="comment" id="update-comment" placeholder="message" required></textarea>
        			</p>

        			<p>
        				<button type="submit" value="poster" name="submit" id="update_submit_btn">poster</button>
        			</p>
        		</form>
        	</article>
        </aside>

    </article>
</section>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/template.php'; ?>
