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
				<img src="src/public/images/alaska1.jpg" alt="glacier Alaska"/>
			</div>
		</div>
	</section>

	<section class="general reveal">

		<header class="titre">
			<h2>Bienvenu sur mon blog
				<?php if(isset($_SESSION))
				{
					echo $_SESSION['pseudo'];
				}?>
			</h2>
		</header>

		<div id="bio">

			<article class="presentation">

				<header class="titreh3">
					<h3>Jean Forteroche, acteur et écrivain</h3>
				</header>

				<div id="bio_fleche">
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

		<div id="bio_fleche">
			<i class="fas fa-chevron-down" id="fleche_bio2"></i>
			<i class="fas fa-chevron-up" id="fleche_haut_2"></i>
		</div>

		<article class="article" id="article_home">
			<!-- <div id="article_home"> -->
				<?php foreach ($Posts as $data): ?>
					<a href="index.php?action=listComments&id=<?= $data->id()?>">
						<div class="articleBloc">
							<header class="titreh3">
								<h3>
									<?php echo htmlspecialchars($data->title()); ?>
								</h3>
								<em> <?php echo htmlspecialchars($data->creation_date() /*== $data->edition_date() ? '-' : $data->edition_date()->format('d/m/Y à H/hi')*/); ?></em>
							</header>

							<!-- <p> -->
							<?php echo substr(html_entity_decode($data->content()), 0, 330) . '...'; ?>

							<!-- </p> -->
							<p id="continu">
								<a href="index.php?action=listComments&id=<?= $data->id(); ?>">Lire la suite...</a>
							</p>

							<div id="icons">
								<em><i class="far fa-comment"></i><?= $data->num_com();?></em>
							</div>
						</div>
					</a>
				<?php endforeach; ?>
				<a href="index.php?action=post"><p id="suite">Retrouvez tous les articles...<p></a>
				<!-- </div> -->
			</article>

			<div id="separate"></div>
			<!-- <a href="index.php?action=AddPostAdmin">Ajouter un article</a> -->
		</section>

		<section class="comments">

			<header class="titre">
				<h2>Les derniers commentaires</h2>
			</header>

			<article class="oneComment">

				<?php foreach ($Comments as $data): /*var_dump($data)*/?>
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
			<!-- <a href="index.php?action=adminCom"> Tous les commentaires</a> -->
		</section>

		<?php $content = ob_get_clean(); ?>

		<?php require ('src/public/template.php'); ?>
