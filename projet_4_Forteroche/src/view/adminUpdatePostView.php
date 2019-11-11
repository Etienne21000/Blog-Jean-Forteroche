<?php $title= 'Jean Forteroche, commentaires'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
	<header class="titre">
		<h3>
			Modifier l'article
		</h3>
	</header>

	<div class="content">

		<aside id="addPost">


			<form action="index.php?action=updatePost&id=<?php/* echo $Post->id(); */?>" method="POST">

				<p>
					<label for="form-title">Titre</label>
					<br>
					<input type="text" name="title" id="form-title" placeholder="titre" required/>
				</p>

				<p>
					<label for="form-content">Chapitre</label>
					<br>
					<textarea type="text" name="content" id="full-featured-non-premium" placeholder="votre texte ici..." required></textarea>
				</p>

				<p>
					<button type="submit" value="poster" name="submit" class="button1">Editer <i class="fas fa-pen-nib"></i></button>
				</p>
			</form>
		</aside>
	</div>
</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
