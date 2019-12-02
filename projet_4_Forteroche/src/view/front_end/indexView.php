<?php $title= 'Jean Forteroche, Billet simple pour l\'Alaska'; ?>

<?php  ob_start(); ?>

<section id="banniere">

	<div id="banniere_description">
		<h1>
			<strong>Alaska</strong>
		</h1>
		<div class="guide">
			<div id="sousTitre">Jean Forteroche <br>
				Billet simple pour l'Alaska
			</div>
		</div>
	</div>

	<div id="slider">
		<div class="slide">
			<span id="calque"> </span>
			<img src="src/public/images/alaska3.jpg" alt="glacier Alaska"/>
		</div>
	</div>
</section>

<section class="general reveal">

	<header class="titre">
		<?php if(!empty($_SESSION))
		{
			echo '<h2>Bienvenu sur mon blog ' . $_SESSION['pseudo'] . '</h2>';
		}
		elseif (empty($_SESSION))
		{
			echo '<h2> Bienvenu sur le blog de Jean Forteroche</h2>';
		}
		?>
	</header>

	<div id="bio">

		<article class="presentation">

			<header class="titreh3">
				<h3>Jean Forteroche, acteur et écrivain</h3>
			</header>

			<div class="bio_fleche">
				<i class="fas fa-chevron-down" id="fleche_bio"></i>
				<i class="fas fa-chevron-up" id="fleche_bio_bas"></i>
			</div>

			<p id="bio_forteroche">
				La philosophie et la médecine ont également bcp à voir dans les relations familiales, notamment Platon dans le Théétète, le Lysis, le Timée et l’Euthyphron.
				Les Politiques d’Aristote critiquent le système Platonicien de la République et renseigne sur les eugéniques, les infanticides et l’avortement.

				Historiens et biographes contribuèrent également à la compréhension de la famille, Hérodote et Thucydide (pas trop) mais Xénophon explore la Constitution des Lacédémoniens. Plutarque dans ses Vies infos sur les coutumes familiales spartiates.

				Epigraphie, permet de déchiffrer les liens familiaux, mariages, alliances etc. liens maitres esclaves etc. Le Code de Gortyne (début du Ve sicècle donc jalon dans les pratiques familiales et leur réglementation) est l’ensemble de texte de lois le plus important de l’antiquité et propose de règlementer la vie familiale (droits, successions, héritages, mariages, relations etc.).
			</p>
		</article>

		<article class="presentation">
			<img id="jeanF" src="src/public/images/jeanF.jpg" alt="Jean Forteroche en Alaska"/>
		</article>

		<div id="separate"></div>

	</div>

</section>

<section class="articles reveal">

	<header class="titre">
		<h2>Les derniers articles de Jean Forteroche</h2>
	</header>

	<div class="bio_fleche">
		<i class="fas fa-chevron-down" id="fleche_bio2"></i>
		<i class="fas fa-chevron-up" id="fleche_haut_2"></i>
	</div>

	<article class="article" id="article_home">
		<?php foreach ($Posts as $data): ?>
			<div class="articleBloc1">
				<header class="titreh3">
					<h3>
						<?= htmlspecialchars($data->title()); ?>
					</h3>
					<em> <?= 'publié le ' . htmlspecialchars($data->creation_date()); ?></em>
				</header>

				<?= substr(html_entity_decode(htmlspecialchars($data->content())), 0, 230) . '...'; ?>

				<p class="continu">
					<a href="index.php?action=listComments&id=<?= $data->id(); ?>"> Lire la suite...</a>
				</p>

				<div class="icons">
					<p class="num_com"><i class="far fa-comment"></i><?= $data->num_com();?></p>
				</div>
			</div>
		<?php endforeach; ?>
		<a href="index.php?action=post"><p class="suite">Retrouvez tous les articles...</p></a>
	</article>

	<div class="separate"></div>
</section>

<section class="comments">

	<header class="titre">
		<h2> <i class="fas fa-comments"></i> Les derniers commentaires</h2>
	</header>

	<article class="oneComment">

		<?php foreach ($Comments as $data): ?>
			<div class="commentBloc">
				<header class="titreh3">
					<p class="com_home">
						<?= htmlspecialchars($data->pseudo()); ?>
					</p>
					<p class="com_home">publié le : <?php echo htmlspecialchars($data->comment_date()); ?></p>
				</header>

				<p class="com_home">
					<?= nl2br(htmlspecialchars($data->comment())); ?>
				</p>
			</div>
		<?php endforeach; ?>
	</article>
</section>

<?php $content = ob_get_clean(); ?>

<?php require ('src/public/template.php'); ?>
