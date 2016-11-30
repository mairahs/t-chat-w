<!-- Pour les requetes du chat j ai besoin de l'id du dernier mesqsage. Ici je fais donc en sorte que cette information soit portée par tous mes messages -->

<?php foreach ($messages as $message): ?> 
	<li data-id="<?php echo $message['id']; ?>"><!-- <span class="personne"><?php //echo htmlentities($message['pseudo']); ?></span> --> <!-- Ici j'ai commenté car comme on a pas fait de jointure on a pas accès aux infos de l'utilisateur --><span class="avatar"><img src="<?php echo $this->assetUrl('uploads/'.$message['avatar']); ?>" alt=""></span><span class ="personne"><?php echo $this ->e($message['pseudo']); ?></span>: <span class="message">"<?php echo htmlentities($message['corps']); ?>"</span></li> 
<?php endforeach; ?> 