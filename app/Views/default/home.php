<?php $this->layout('layout', ['title' => 'Accueil', 'subtitle' => 'Accueil de Tchat']) ?>

<?php $this->start('main_content') ?>
	<h2>Bienvenue <?php echo $w_user ? $w_user['pseudo'] : '' ; ?></h2>
	<p>J'ai réussi à modifier la page d'accueil</p>
	<p>Je suis trop forte <strong><a href="../docs/tuto/" title="Documentation de W">docs/tuto</a></strong>.</p>
<?php $this->stop('main_content') ?>
