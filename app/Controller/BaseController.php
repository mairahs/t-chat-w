<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\SalonsModel;
use \Plasticbrain\FlashMessages\FlashMessages;

class BaseController extends Controller
{

	/*
	*ce champs va contenir l'engine de Plates qui va servir à afficher mes vues
	*/
	protected $engine;

	/*
	*ce champ va contenir une instance de flash messenger de php-flash-messages
	*/
	protected $fmsg;

	public function __construct(){

		//Je fais appel à la méthode __construct() de la classe parente (controller), ce qui me permet de surcharger cette méthode et non de la redéfinir entièrement
		//parent::__construct();En fait Thibault découvre que le constructeur de la classe parante controller n'existe pas et en PHP on a pas le droit de surcharger un constructeur qui n'existe pas

		// Je stocke dans la variable de classe engine une instance de League\Plate\Engine alors que cette instance était créé directement dans la méthode show() de Controller et n'était accessible qu' à ce nivo là

		$this ->engine = new \League\Plates\Engine(self::PATH_VIEWS);// donc la on fait dans le constructeur de ma nouvelle classe ce qu on faisait dans le controleur avant

		//charge nos extensions (nos fonctions personnalisées)
		$this->engine->loadExtension(new \W\View\Plates\PlatesExtensions());

		$app = getApp();

		// Rend certaines données disponibles à tous les vues
		// accessible avec $w_user & $w_current_route dans les fichiers de vue

		$salonsModel = new SalonsModel();
		$this ->fmsg = new FlashMessages();
		$this->engine->addData(
			[
				'w_user' 		  => $this->getUser(),
				'w_current_route' => $app->getCurrentRoute(),
				'w_site_name'	  => $app->getConfig('site_name'),
				'salons'		  => $salonsModel->findAll(), // dans notre contructeur BC on instancie un nouveau modele et on s'en sert pour assigner tous nos nouveaux salons apres avoir mis en global le engine on lui rajoute la liste des salons avec les datas et enfin on s en sert dans notre nouvelle méthode show qui sera affichée en globale
				'fmsg'            => $this->getFlashMessenger()
			]
		);

		
	}

	public function show($file, array $data = array()){

		// Retire l'éventuelle extension .php
		$file = str_replace('.php', '', $file);

		// Affiche le template
		echo $this->engine->render($file, $data);
		die();

	}

	//avec l'engine on est sur que les données seront globales c a d que engine va envoyer les datas qu on lui donnera à toutes nos vues qu on aura fabriquées ces datas seront donc dispo de façon globale dans toutes nos vues
	//Cette fonction sert donc à ajoputer des données qui seront disponibles dans toutes les vues fabriquées $this->engine donc par le BaseControlleur
	//par exeple pour ajouter une liste d'utilisateurs à mes vues, j'utillise $this->addGlobalData(array('users'=>$users)) $this et non pas $this->engine car addGlobalData() est une méthode du contoleur
	public function addGlobalData(array $datas){

		$this ->engine ->addData($datas);
	}

	public function getFlashMessenger(){

		return $this->fmsg;
	}
}