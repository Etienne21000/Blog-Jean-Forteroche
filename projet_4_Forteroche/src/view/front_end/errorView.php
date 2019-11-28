<?php $title= 'Jean Forteroche, commentaires'; ?>

<?php  ob_start(); ?>

<section id="banniere_alt">

	<div id="banniere_description_alt">
		<h1>
			<strong> Une erreur est survenue </strong>
		</h1>

	</div>
	<div id="slider_alt">
		<div class="slide_alt">
			<span id="calque_alt"> </span>
			<img src="src/public/images/alaska6.jpg" alt="glacier Alaska"/>
		</div>
	</div>
</section>

<section class="general">
	<article class="blocAdmin">
		<article class="commentAdmin">
			<h3>
                Oups, impossible charger cette page...
            </h3>
            <p>
                <a href="index.php?action=Accueil" title="Retour à l'accueil">Revenir à l'accueil</a>
            </p>
		</article>
	</article>
</section>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/template.php'; ?>
