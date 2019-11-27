<?php $title= 'Connexion administrateur'; ?>

<?php  ob_start(); ?>

<section class="connexion">
	<aside class="Admin">

		<header class="titre">
			<h4>
				Connexion
			</h4>
		</header>
		<p>
			<a href="index.php?action=inscription">Pas encore inscrit ?</a>
		</p>


		<div id="form-admin">
			<form action="index.php?action=connectUser" method="POST">
				<p>
					<label for="form-utilisateur">Nom d'utilisateur</label>
					<br>
					<input type="text" name="pseudo" id="form-utilisateur" placeholder="nom d'utilisateur" required/>
				</p>

				<p>
					<label for="form-mp">Mot de passe</label>
					<br>
					<input type="password" name="pass" id="form-mp" placeholder="mot de passe" required/>
				</p>

				<p>
					<button type="submit" value="poster" name="submit" id="submit_adm_btn">valider</button>
				</p>
			</form>
		</div>
		<?php if($error)
		{?>
			<p id="error">
				<?php echo $error;?>
			</p>
		<?php	}?>
	</aside>
</section>

<?php $content = ob_get_clean(); ?>

<?php require ('src/public/template.php'); ?>
