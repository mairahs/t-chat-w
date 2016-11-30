<?php
$this -> layout('layout', ['title' =>'Connectez-vous']);

$this-> start('main_content'); ?>

	<h2>Connectez-vous à  T'Chat</h2>

				<?php $fmsg->display(); ?>

				<form action="<?php echo $this->url('login') ?>" method="POST">

					<p>
						<label for ="pseudo">Entrez votre pseudo:</label>
						<input type="text" name="pseudo" id="pseudo" value ="<?php echo isset($datas['pseudo']) ? $datas['pseudo'] : '' ?>">
						<!-- on a fait un isset car la première fois qu'on arrive sur le formulaire, les données n'existent pas car on a pas encore rempli le tableau en revanche on ne faitr pas ça sur le mdp car faille de sécutité -->
					
					</p>

					<p>
						<label for ="password">Entrez votre mot de passe:</label>
						<input type="password" name="mot_de_passe" id="password">
						
					</p>

					<p>
						<input type="submit" value="Connectez-vous!" class="button">
						<a href="<?php echo $this->url('register'); ?>" title="accédez à  la page d'inscription">Pas encore inscrit ?</a>
					</p>

					
					
				</form>

<?php

$this-> stop('main_content');