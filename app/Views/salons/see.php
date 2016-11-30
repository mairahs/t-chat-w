<?php
	$this->layout('layout', ['title' =>'Messages de mon salon']);

	$this->start('main_content'); ?>

		<h2>Bienvenue sur le salon <?php echo $this->e ($salon['nom']); ?></h2> 
			<!-- Ici on a accès uniquement à $salon et $messages car ce sont les clés de mon array sans SalonsController -->
					<ol class ="messages">
						<?php $this->insert('salons/inc.messages',['messages'=>$messages]); ?>
					</ol>

					<!-- J'envoie mon formulaire d'ajout de message sur la page courante cela va me permettre d'ajouter mes messages Ã  ce salon et pas Ã  un autre via l'id 
					  $this->url('see_salon', array('id' =>$salon['id'])) va générer une url du genre t-chat-w/public/salon/$salon['id']-->

					 <!-- On affiche le formulaire que si l'utilisateur est connecté -->

					 <?php if($w_user): ?>
					<form class="form-message" action="<?php $this -> url('see_salon', array('id'=>$salon['id'])); ?>" method="POST">

						<textarea name ="corps"></textarea>
						<input type="submit" class="button" value="Poster son message">
						
					</form>
				<?php else: ?>
					<a href="<?php echo $this->url('login'); ?>" title="Connectez-vous pour poster un message" class="button">Connectez-vous pour poster un message</a>
				<?php endif; ?>


	<?php $this -> stop('main_content'); ?>

	<?php $this->start('javascripts');?>

	<script type="text/javascript" src="<?php echo $this->assetUrl('js/prepare-chat.js'); ?>"></script>

	<script type="text/javascript">
		
		var salonId = <?php echo $salon['id']; ?>;//on récupère l'id du salon
		var homeURL = '<?php echo $this->url('default_home'); ?>'//pour être sure que mon url aura toujours le bon radical qu on soit en ligne ou pas elle sera donc toujours valide quelque soit la position de mon projet

		$(document).ready(function(){

			setInterval(function(){
				var lastMessageId = $('.messages > li:last-child').attr('data-id') || 0;

				//pour préciser qu on est en train d 'écrire

				$('textarea[name = "corps"]').on('textarea', function(){

					$.get(homeURL+'writing/'+salonId, [], function(data){
						//traitement à la réception de l'info "machin est en train d'écrire"
					});
				});
				$.get(homeURL+'newmessages/'+salonId+'/'+lastMessageId, [], function(data){

					$('.messages').append(data).scrollTop($('.messages').height());

				});
			},500)

		});
	</script>

	<?php $this->stop('javascripts');?>

 