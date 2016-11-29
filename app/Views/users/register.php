<?php
	

	function afficherPosts($champ){
		// je vÃ©rifie qu une valeur a bien Ã©tÃ© postÃ©e pour ce nom de champ et si c'est le cas, j affiche cette valeur
		echo !empty($_POST[$champ]) ? $_POST[$champ] : '';
	}

	function afficherCheck($valeurAttendue){

		//si on a renseignÃ© un sexe en POST et que la valeur rentrÃ©e en POST est celle qui est attendue par l'input radio, alors on veut cocher cet input

		echo !empty($_POST['sexe']) && $_POST['sexe'] == $valeurAttendue ? 'checked' : '';

	}

	$this->layout('layout',['title'=>'Inscrivez-vous']);

	$this->start('main_content'); ?>

		<h2 class='inscription'>Inscription d'un utilisateur</h2>

			<?php $fmsg ->display(); ?>

					<form action='<?php echo $this->url('register'); ?>' method='POST' enctype = "multipart/form-data" class="inscription">
						
						<p>
							<label for="pseudo">Votre pseudo</label>
							<input type="text" name="pseudo" id="pseudo" placeholder="Entre 3 et  50 caractères" value="<?php afficherPosts('pseudo'); ?>">
							
						</p>
						<p>
							<label for="email">Votre email</label>
							<input type="email" name="email" id="email" value="<?php afficherPosts('email'); ?>">
							
						</p>
						<p>
							<label for="password">Votre mot de passe</label>
							<input type="password" name="mot_de_passe" id="password" value="<?php afficherPosts('mot_de_passe'); ?>">
							
						</p>
						<p>
							<label for="femme">Femme</label>
							<input type="radio" name="sexe" id="femme" value="femme" <?php afficherCheck('femme'); ?>>
						</p>
						<p>
							<label for="homme">Homme</label>
							<input type="radio" name="sexe" id="homme" value="homme" <?php afficherCheck('homme'); ?>>
						</p>
						<p>
							<label for="non-defini">Non-défini</label>
							<input type="radio" name="sexe" id="non-defini" value="non-defini" <?php afficherCheck('non-defini');?>>
							
						</p>
						<p>
							<label for="avatar">Votre avatar</label>
							<input type="file" name="avatar" id="avatar">
							
						</p>

						<p>
							<input type="submit" name="send" value="Je m'inscris" class="button">
						</p>

					</form>

<?php
	$this->stop('main_content');

 ?>