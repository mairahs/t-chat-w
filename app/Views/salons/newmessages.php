<?php 

//Exceptionnellement on inscrit pas cdette vue dans un layout car elle ne s'exécuter que dans un contexte ajax. Je n'ai donc besoin que de la partie qui m'interesse, à savoir la liste des nouveaux messages donc en l'occurrence les li on peut faire un copié coller de la boucle de see.php mais le prb est qu on duplique du code et c pas bon donc le framework prévoit une fonction insert() dans les vues pour régler ce cas insert() fonctionne comme show() sauf qu'elle insère des morceaux de vue dupliqué

$this->insert('salons/inc.messages',['messages'=>$messages]);

?>