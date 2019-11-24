<?php $title= 'Jean Forteroche, commentaires'; ?>

<?php  ob_start(); ?>

<section class="general">
	<div class="articles">
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
				<?= html_entity_decode(htmlspecialchars($post->content())); ?>
			</p>
			<?php if($_SESSION):?>
				<em>
					<a href="#form" class="js-form" title="Répondre"><i class="fas fa-reply"></i></a>
				</em>
			<?php endif; ?>
			<?php if(!$_SESSION):?>
				<p>
					<a href="index.php?action=AdminConnexion"><i class="fas fa-sign-in-alt"></i>Connectez-vous pour laisser un commentaire</a>
				</p>
			<?php endif; ?>
		</article>
	</div>

	<article class="commentaires">
		<header class="titre">
			<h4>Retrouvez les derniers commentaires</h4>
		</header>

		<?php foreach ($Comments as $data): ?>
			<p class="author">

				<strong><?= htmlspecialchars($data->pseudo()); ?>
				</strong>
				le
				<?= htmlspecialchars($data->comment_date()); ?>
			</p>

			<div class="comment">
				<p>
					<?= nl2br(html_entity_decode(htmlspecialchars($data->comment()))); ?>
					<div class="icons">
						<a href="index.php?action=reportComment&id=<?= $data->id(); ?>" title="Signaler"><i class="fas fa-exclamation-circle"></i></a>
					</div>
				</p>
			</div>
		<?php endforeach; ?>


	</article>
</section>

<aside id="form" aria-hidden="true" role="dialog" aria-labelledby="titre-form">
	<article id="form-wrapper">
		<i class="fas fa-times" id="cross"></i>
		<header class="titre titre-form">
			<h4>Laissez un commentaire</h4>
		</header>
			<form action="index.php?action=addComment&amp;id=<?= $post->id(); ?>" method="POST">

				<p>
					<?php echo $_SESSION['pseudo']; ?>
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

	<?php $content = ob_get_clean(); ?>

	<?php require 'src/public/template.php'; ?>
