<?php $title= 'Jean Forteroche, mise a jour article'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
	<header class="titre">
		<h3>
			Modifier l'article
		</h3>
	</header>

	<div class="content">

		<aside id="addPost">
			<form action="index.php?action=updatePost" method="POST" charset="utf-8">

				<p>
					<label for="form-title">Titre</label>
					<br>
					<input type="text" name="title" id="form-title" value="<?= $post->title();?>" required/>
				</p>

				<p>
					<label for="form-content">Chapitre</label>
					<br>
					<textarea type="textarea" name="content" cols="70" rows="30" id="full-featured-non-premium" value="" ><?= $post->content();?></textarea>
				</p>

				<p>
					<button type="submit" value="submit" name="submit" class="button1">Editer <i class="fas fa-pen-nib"></i></button>
				</p>
			</form>
		</aside>
	</div>
</article>

<?php $content = ob_get_clean(); ?>

<?php require 'src/public/templateAdmin.php'; ?>
