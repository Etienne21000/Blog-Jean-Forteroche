<?php $title= 'Connexion administrateur'; ?>

<?php  ob_start(); ?>

<section class="connexion">

	<aside class="Admin">
		<header class="titre">
			<h4>
				Inscription
			</h4>
		</header>

		<p>
			<a href="index.php?action=AdminConnexion">Déjà inscrit ?</a>
		</p>
		<div id="form-inscription">
			<form action="index.php?action=userInscription" method="POST">
				<p>
					<label for="form-utilisateur">Pseudo</label>
					<br>
					<input type="text" name="pseudo" id="form-utilisateur" placeholder="" required/>
				</p>

				<p>
					<label for="form-utilisateur">e-mail</label>
					<br>
					<input type="text" name="mail" id="form-mail" placeholder="" required/>
				</p>

				<p>
					<label for="form-mp">Mot de passe</label>
					<br>
					<input type="password" name="pass" id="form-mp" placeholder="" required/>
				</p>

				<p>
					<label for="form-mp">Confirmer le mot de passe</label>
					<br>
					<input type="password" name="confirmePass" id="form-mp-confirm" placeholder="" required/>
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
