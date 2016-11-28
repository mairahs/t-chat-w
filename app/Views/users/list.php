<?php

	$this -> layout('layout', ['title' => 'Liste des utilisateurs']);

	$this -> start('main_content'); ?>

		<ul>
			<?php foreach ($listUsers as $user): ?><!-- c'est via $listUsers qui est en fait l'index du tableau passé en parametre dans la fonction show du userController que le C transmet des données à la V -->

				<li><?php echo $user['pseudo']; ?></li>

			<?php endforeach; ?>

		</ul>



	<?php $this -> stop('main_content'); ?>



 ?>


