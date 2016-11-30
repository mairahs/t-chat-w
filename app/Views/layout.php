<!DOCTYPE html>

<html lang="fr">
	<head>
		<title><?php echo $this->e($title);?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- $this -> assetUrl('css/style.css') vaudra 'assets/css/style.css' -->
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetUrl('css/reset.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo $this->assetUrl('css/style.css'); ?>">

	</head>

	<body>
		<header>

			<h1><?php echo $this->e($title); ?></h1>

		</header>

	

		<aside>

			
			<h3><a href="<?php echo $this->url('default_home'); ?>" title="Revenir à l'accueil">Les salons</a></h3>
						
						<nav>
								<ul class="menu-salons">

									<?php foreach ($salons as $salon): ?>

										<li><a href="<?php echo $this->url('see_salon', array('id' => $salon['id'])); ?>"><?php echo $this->e($salon['nom']); ?></a></li>
									<?php endforeach; ?>

									<?php if(in_array($w_user['role'], ['admin','superadmin'])): ?>

									<li><a href="<?php echo $this->url('users_list'); ?>" title="Liste des utilisateurs">Liste des utilisateurs</a><br/></li>
								<?php endif; ?>

									<?php if($w_user): ?>
									<li><a href="<?php echo $this->url('logout'); ?>" title="Se déconnecter de T-Chat">Déconnexion</a></li>
									<?php else: ?>
									<li><a href="<?php echo $this->url('login'); ?>" title="Accéder au formulaire de connexion">Connexion</a></li>
								<?php endif; ?>


								</ul>		
						</nav>

					
		</aside><main>


			<section>
				<?php $fmsg->display(); ?>
				<?= $this->section('main_content') ?>
			</section>
		</main>

		<footer></footer>

		<script
		  src="https://code.jquery.com/jquery-2.2.4.js"
		  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
		  crossorigin="anonymous"></script>

		  <script type="text/javascript" src="<?php echo $this->assetUrl('js/close-flash-messages.js'); ?>"></script>
		  <?php $sectionJavascripts = $this->section('javascripts');

		  	if($sectionJavascripts){
		  		echo $sectionJavascripts;
		  	}

		   ?>

	</body>
</html>
