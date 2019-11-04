<?php $title= 'Jean Forteroche, publication sélectionnée'; ?>

<?php  ob_start(); ?>

<section id="general">
	<article class="articles">
		<header class="titre">
			<h3>
				<?= htmlspecialchars($Posts->title());
				?>
			</h3>
		</header>

		<p>
			<?= 'Billet créé le : ' . htmlspecialchars($Posts->creation_date()); ?>
		</p>

		<p>
			<?= nl2br(htmlspecialchars($Posts->content())); ?>
		</p>

	</article>

	<article class="commentaires">
		<header class="titre">
			<h4>Retrouvez les derniers commentaires</h4>
		</header>

		<?php foreach ($Comments as $data): /*var_dump($data);*/ ?>
			<p id="author">

				<strong><?= htmlspecialchars($data->author()); ?></strong> le
				<?= htmlspecialchars($data->comment_date());
				// var_dump($data->comment_date()); ?>
			</p>

			<div id="comment">
				<p>
					<?= nl2br(htmlspecialchars($data->comment())); ?>
				</p>
				<a href="index.php?action=deleteComment&post=<?= $data->id() ?>"><i class="fas fa-times"></i></a>
			</div>

		<?php endforeach; ?>
	</article>
</section>

<section id="formulaire">
	<article class="commentaires">

		<header class="titre">
			<h4>Laissez un commentaire</h4>
		</header>

		<form action="index.php?action=addComment&amp;id=<?= $Posts->id(); ?>" method="POST">
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
</section>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/template.php'; ?>
