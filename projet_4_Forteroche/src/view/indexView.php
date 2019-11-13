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
		<div id="slider">
			<div class="slide">
				<span id="calque"> </span>
				<img src="src/public/images/alaska3.jpg" alt="glacier Alaska"/>
			</div>
		</div>
	</section>

	<section class="general reveal">

		<header class="titre">
			<h2>Bonjour vous êtes sur le blog de Jean Forteroche</h2>
		</header>

		<div id="bio">

			<article class="presentation">
				<header class="titreh3">
					<h3>Jean Forteroche, acteur et écrivain</h3>
				</header>
				<p>
					La philosophie et la médecine ont également bcp à voir dans les relations familiales, notamment Platon dans le Théétète, le Lysis, le Timée et l’Euthyphron.
					Les Politiques d’Aristote critiquent le système Platonicien de la République et renseigne sur les eugéniques, les infanticides et l’avortement.

					Historiens et biographes contribuèrent également à la compréhension de la famille, Hérodote et Thucydide (pas trop) mais Xénophon explore la Constitution des Lacédémoniens. Plutarque dans ses Vies infos sur les coutumes familiales spartiates.

					Epigraphie, permet de déchiffrer les liens familiaux, mariages, alliances etc. liens maitres esclaves etc. Le Code de Gortyne (début du Ve sicècle donc jalon dans les pratiques familiales et leur réglementation) est l’ensemble de texte de lois le plus important de l’antiquité et propose de règlementer la vie familiale (droits, successions, héritages, mariages, relations etc.).
				</p>
			</article>

			<article class="presentation">
				<header class="titreh3">
					<h3>Jean Forteroche</h3>
				</header>
				<img id="jeanF" src="src/public/images/jeanF.jpg" alt="Jean Forteroche en Alaska"/>
				<p>
					La philosophie et la médecine ont également bcp à voir dans les relations familiales, notamment Platon dans le Théétète, le Lysis, le Timée et l’Euthyphron.
					Les Politiques d’Aristote critiquent le système Platonicien de la République et renseigne sur les eugéniques, les infanticides et l’avortement.
				</p>
			</article>

		</div>

	</section>

	<section class="articles reveal">

		<header class="titre">
			<h2>Retrouvez les derniers articles de Jean Forteroche</h2>
		</header>

		<article class="article">

			<?php foreach ($Posts as $data): ?>
				<a href="index.php?action=listComments&id=<?= $data->id()?>">
					<div class="articleBloc">
						<header class="titreh3">
							<h3>
								<?php echo htmlspecialchars($data->title()); ?>
							</h3>
							<em> <?php echo htmlspecialchars($data->creation_date()); ?></em>
						</header>

						<!-- <p> -->
							<?php echo substr(html_entity_decode($data->content(), ENT_HTML5, 'UTF-8'), 0,330) . '...'; ?>

						<!-- </p> -->
						<p id="continu">
							<a href="index.php?action=listComments&id=<?= $data->id(); ?>">Lire la suite...</a>
						</p>

						<div id="icons">
							<em> <?= $data->num_com() . '<i class="far fa-comment"></i>'; ?></em>
							<!-- <em><a href="index.php?action=listComments&id=<?php/* $data->id(); */?>"><i class="far fa-comment"></i> </a> <?= $countByPost; ?></em> -->
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</article>
		<!-- <a href="index.php?action=AddPostAdmin">Ajouter un article</a> -->
	</section>

	<section class="comments">

		<header class="titre">
			<h2>Retrouvez les derniers commentaires</h2>
		</header>

		<article class="oneComment">

			<?php foreach ($Comments as $data): /*var_dump($data)*/?>
					<div class="commentBloc">
						<header class="titreh3">
							<p>
								<?= htmlspecialchars($data->author()); ?>
							</p>
							<p>publié le : <?php echo htmlspecialchars($data->comment_date()); ?></p>
						</header>

						<p>
							<?= nl2br(htmlspecialchars($data->comment())); ?>
						</p>
					</div>
			<?php endforeach; ?>
		</article>
		<!-- <a href="index.php?action=adminCom"> Tous les commentaires</a> -->
	</section>

	<?php $content = ob_get_clean(); ?>

	<?php require ('src/public/template.php'); ?>
