<?php $title= 'Jean Forteroche, commentaires'; ?>

<?php  ob_start(); ?>
<section class="general">

	<article class="commentaires">
		<header class="titre">
			<h4>Retrouvez les derniers commentaires</h4>
		</header>

		<?php foreach ($Comments as $data): ?>
			<p class="author">

				<strong><?= htmlspecialchars($data->author()); ?></strong> le
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
			<!-- </div> -->
		<?php endforeach; ?>

		<a href="/">Retour à l'accueil</a>

		<em><a href="#form" class="js-form" title="Répondre"><i class="fas fa-reply"></i></a></em>

	</article>
</section>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/template.php'; ?>
