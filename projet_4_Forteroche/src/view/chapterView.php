<?php $title= 'Jean Forteroche, tous les articles'; ?>

<?php  ob_start(); ?>

<section class="general">

	<header class="titre">
		<h2>Retrouvez les derniers articles de Jean Forteroche</h2>
	</header>
	<!-- <p>
		<?php/* echo '(' . $countPosts . ')'; */?> articles
	</p> -->

	<article class="articles">

		<?php foreach ($Posts as $data): ?>
			<header class="titreh3">
				<h3>
					<?php echo htmlspecialchars($data->title());?>
				</h3>
				<em> <?php echo htmlspecialchars($data->creation_date());  ?></em>
			</header>

			<p>
				<?php echo substr(nl2br(htmlspecialchars($data->content())),0,500) . '...'; ?>
			</p>
			<p id="continu">
				<a href="index.php?action=listComments&post=<?= $data->id(); ?>"> Lire la suite...</a>
			</p>
			<br>

			<div id="icons">
				<em><a href="index.php?action=listComments&post=<?= $data->id(); ?>"><i class="far fa-comment"></i></a></em>
				<em><a href=""><i class="fas fa-reply"></i></a></em>
			</div>
		<?php endforeach; ?>

	</article>
</section>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/template.php'; ?>
