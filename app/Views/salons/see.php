<?php
	$this->layout('layout', ['title' =>'Messages de mon salon']);

	$this->start('main_content'); ?>

		<h2>Bienvenue sur le salon <?php echo $this->e ($salon['nom']); ?></h2> 
			<!-- Ici on a accès uniquement à $salon et $messages car ce sont les clés de mon array sans SalonsController -->
					<ol class ="messages">
						 <?php foreach ($messages as $message): ?> 
						<li><!-- <span class="personne"><?php //echo htmlentities($message['pseudo']); ?></span> --> <!-- Ici j'ai commenté car comme on a pas fait de jointure on a pas accès aux infos de l'utilisateur --><span class ="personne"><?php echo $this ->e($message['pseudo']); ?></span>: <span class="message">"<?php echo htmlentities($message['corps']); ?>"</span></li> 
						 <?php endforeach; ?> 
					</ol>

					<!-- J'envoie mon formulaire d'ajout de message sur la page courante cela va me permettre d'ajouter mes messages Ã  ce salon et pas Ã  un autre via l'id 
					  $this->url('see_salon', array('id' =>$salon['id'])) va générer une url du genre t-chat-w/public/salon/$salon['id']-->

					<form class="form-message" action="<?php $this -> url('see_salon', array('id'=>$salon['id'])); ?>" method="POST">

						<textarea name ="corps"></textarea>
						<input type="submit" class="button" value="Poster son message">
						
					</form>


	<?php $this -> stop('main_content'); ?>

 ?>