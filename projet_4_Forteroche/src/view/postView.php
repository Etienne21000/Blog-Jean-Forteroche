<?php $title= 'Jean Forteroche, commentaires'; ?>

<?php  ob_start(); ?>

<section class="general">
	<article class="article">
		<header class="titre">
			<h3>
				<?= htmlspecialchars($post->title()); ?>
			</h3>
			<p id="date">
				<?= 'Billet créé le : ' . htmlspecialchars($post->creation_date()); ?>
			</p>
		</header>



		<p>
			<?= nl2br(htmlspecialchars($post->content())); ?>
		</p>

		<a href="index.php?action=listPosts">Retour à l'accueil</a>
	</article>

	<article class="commentaires">
		<header class="titre">
			<h4>Retrouvez les derniers commentaires</h4>
		</header>

		<?php foreach ($Comment as $data): ?>
			<p class="author">

				<strong><?= htmlspecialchars($data->author()); ?>
				</strong>
				le
				<?= htmlspecialchars($data->comment_date()); ?>
			</p>

			<div class="comment">
				<p>
					<?= nl2br(htmlspecialchars($data->comment())); ?>
					<div class="icons">
						<a href="index.php?action=deleteCom&amp;id=<?= $data->id() ?>" title="Supprimer"><i class="fas fa-times"></i></a>
						<a href="#update" class="js-update" title="Mettre à jour"><i class="fas fa-comment-dots"></i></a>
					</div>
				</p>
			</div>
		<?php endforeach; ?>

		<em><a href="#form" class="js-form" title="Répondre"><i class="fas fa-reply"></i></a></em>

	</article>
</section>

<aside id="form" aria-hidden="true" role="dialog" aria-labelledby="titre-form">
	<article id="form-wrapper">
		<i class="fas fa-times" id="cross"></i>
		<header class="titre titre-form">
			<h4>Laissez un commentaire</h4>
		</header>
		<?php /*foreach ($Posts as $data):*/ ?>
			<form action="index.php?action=addComment&amp;id=<?= $post->id(); ?>" method="POST">
				<p>
					<label for="form-pseudo">Pseudo</label>
					<br>
					<input type="text" name="author" id="form-pseudo" placeholder="pseudo" required/>
				</p>

				<p>
					<label for="form-comment">message</label>
					<br>
					<textarea type="text" name="comment" id="form-comment" placeholder="message" required></textarea>
				</p>

				<p>
					<button type="submit" value="poster" name="submit" id="submit_btn">poster</button>
				</p>
			</form>
	</article>

</aside>

<!--Update form-->

<aside id="update" aria-hidden="true" role="dialog" aria-labelledby="titre-update">
	<article id="update-wrapper">
		<i class="fas fa-times" id="crossUpdate"></i>
		<header class="titre titre-update">
			<h4>Mettre à jour le commentaire</h4>
		</header>
			<form action="index.php?action=updateComment&amp;id=<?= $post->id(); ?>" method="POST">
				<?php/* foreach ($Comment as $data): */?>
				<p>
					Auteur :
					<br>
					Commentarie à modifier :
				</p>
			<?php /*endforeach; */?>
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

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/template.php'; ?>
