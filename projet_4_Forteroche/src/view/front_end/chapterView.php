<?php $title= 'Jean Forteroche, tous les articles'; ?>

<?php  ob_start(); ?>

<section id="banniere_alt">

	<div id="banniere_description_alt">
		<h1>
			<strong>Les chapitres</strong>
		</h1>
		
	<div id="slider_alt">
		<div class="slide_alt">
			<span id="calque_alt"> </span>
			<img src="src/public/images/alaska7.jpg" alt="glacier Alaska"/>
		</div>
	</div>
</section>

<section class="general">

	<header class="titre">
		<h2>Retrouvez les derniers articles de Jean Forteroche</h2>
	</header>

	<article class="article">

		<?php foreach ($Posts as $data): ?>
			<a href="index.php?action=listComments&id=<?= $data->id()?>">
				<div class="articleBloc">
					<header class="titreh3">
						<h3>
							<?php echo htmlspecialchars($data->title());?>
						</h3>
						<em> <?php echo htmlspecialchars($data->creation_date());  ?></em>
					</header>

					<!-- <p> -->
						<?php echo substr(html_entity_decode($data->content()), 0,550) . '...'; ?>
					<!-- </p> -->
					<p id="continu">
						<a href="index.php?action=listComments&post=<?= $data->id(); ?>"> Lire la suite...</a>
					</p>
					<br>

					<div id="icons">
						<p id="num_com"><i class="far fa-comment"></i><?= $data->num_com();?></p>
					</div>
				</div>
			</a>
		<?php endforeach; ?>

	</article>
</section>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/template.php'; ?>
