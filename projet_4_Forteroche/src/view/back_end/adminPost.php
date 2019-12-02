<?php $title= 'Jean Forteroche, ajouter un article'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
	<header class="titre">
		<h4>
			Nouvel article
		</h4>
	</header>

	<div class="content">

		<aside id="addPost">
			<form action="index.php?action=addPost" method="post" charset="utf-8">

				<p>
					<label for="form-title">Titre</label>
					<br>
					<input type="text" name="title" id="form-title" placeholder="titre" required/>
				</p>

				<p>
					<label for="form-content">Chapitre</label>
					<br>
					<textarea type="textarea" name="content" id="full-featured-non-premium" charset="utf-8"></textarea>
				</p>

				<p>
					<button type="submit" value="submit" name="submit" class="button2">Ajouter <i class="fas fa-paper-plane"></i></button>
				</p>
			</form>
		</aside>

	</div>
</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
