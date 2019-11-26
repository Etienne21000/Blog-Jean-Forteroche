<?php $title= 'Jean Forteroche, mise a jour article'; ?>

<?php  ob_start(); ?>

<article class="blocAdmin">
	<header class="titre">
		<h4>
			Modifier le commentaire
		</h4>
	</header>

	<div class="content">
		<aside id="addPost">
			<form action="index.php?action=updateComment&amp;id=<?= $Comment->id(); ?>" method="POST">

				<p>
					Commentaire de : <?= $Comment->pseudo(); ?>
                    <br>
                    publié le <?= $Comment->comment_date(); ?>
				</p>
				<p>
					<label for="form-content">Commentaire à modifier</label>
					<br>
					<textarea type="textarea" name="comment" cols="70" rows="30" id="form-comment"><?= $Comment->comment();?></textarea>
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
