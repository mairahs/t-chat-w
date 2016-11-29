<?php

namespace Controller;

//use \W\Controller\Controller;
use Model\UtilisateursModel;
use W\Security\AuthentificationModel;

class UserController extends BaseController
{

	/*
	*Cette fonction sert à afficher la liste des utilisateurs
	*/
	public function listUsers()
	{
		//$usersList = array("Googleman", "Pausewoman","Christine","Marine");

		// La ligne suivante affiche la vue présente dans app/Views/users/list.php et y injecte le tablo $usersList sous un nouveau nom $listUsers

		//Ici j'instancie depuis l action du controleur un modele d utilisateur pour pouvoiur accéder à la liste des utilisateurs

		$usersModel = new UtilisateursModel();
		$usersList = $usersModel ->findAll();

		$this->show('users/list', array('listUsers'=>$usersList));
	}

	public function login(){

		//utilisation du modèle d'authentificaion et plus particulièrement la méthode isValidLoginInfos à laquelle on passera en parametre le le pseudo/email et la password envoyé en post par l'utilisateur. Une fois cxette vérificatiopn faite on récupère l'utilisateur en bdd, on le connecte et on le redirige vers la page d'accueil

		//je vérifie la non vacuité du pseudo en post

		if(!empty($_POST)){

			if(empty($_POST['pseudo'])){
				 //erreur pseudo
			}

			if(empty($_POST['mot_de_passe'])){

				//erreur mot de passe
			}

			$auth = new AuthentificationModel();

			if(!empty($_POST['pseudo']) && !empty($_POST['mot_de_passe'])){

				//vérification de l'existence de l'utilisateur en BDD si il le trouve il me renvoit son id sinon il me renvoit 0

				$idUser = $auth ->isValidLoginInfo($_POST['pseudo'], $_POST['mot_de_passe']);

				// Si l'utilisateur existe bien

				if($idUser !== 0){

					$utilisateurModel = new UtilisateursModel();

					//je récupère les infos de l'utilisateur et je m'en sers pour le connecter au site à l'aide de $auth->logUserIn()

					$userInfos = $utilisateurModel->find($idUser);
					$auth ->logUserIn($userInfos);// sert à connecter l'utilisateur à partir de ses infos. Donc à partir de là, mon utilisateur est connecté

					//une fois l'utilisateur connecté, je le redirige vers l'accueil
					$this->redirectToRoute('default_home'); // cette méthode elle par contre fait partie de mon controller
				}else{

					// les infos de connexion sont incorrectes on a trouvé aucun id en bdd qui coorespond à la combinaison pseudo / mot de passe
				}

			}

		}

		
		$this->show('users/login', array('datas' => isset($_POST) ? $_POST : array())); // ser à remplir la value du form pour que l'utilisateur n'ait pas à remplir toutes les données en cas d'erreur on injecte donc dans la vue les données sous la forme $datas et la condition ternaire c'est parce que, comme on est en dehors du if on veut être sur que $_POST existe bien à ce niveau là
	}

	public function logout(){

		$auth = new AuthentificationModel();
		$auth->logUserOut();
		$this->redirectToRoute('login');
	}

}