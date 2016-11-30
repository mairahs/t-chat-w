<?php

namespace Controller;

//use \W\Controller\Controller;
use Model\UtilisateursModel;
use W\Security\AuthentificationModel;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

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

		$this->allowTo(['admin','superadmin']);

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
				$this->getFlashMessenger()->error('Veuillez renseigner un pseudo');
			}

			if(empty($_POST['mot_de_passe'])){

				//erreur mot de passe
				$this->getFlashMessenger()->error('Veuillez renseigner un mot de passe');
			}
			

			$auth = new AuthentificationModel();

			if( !$this ->getFlashMessenger() ->hasErrors()){

			//if(!empty($_POST['pseudo']) && !empty($_POST['mot_de_passe'])){

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

					$this->getFlashMessenger()->error('Vos informations de connexion sont incorrectes');
				}

			}

		}

		
		$this->show('users/login', array('datas' => isset($_POST) ? $_POST : array())); // sert à remplir la value du form pour que l'utilisateur n'ait pas à remplir toutes les données en cas d'erreur on injecte donc dans la vue les données sous la forme $datas et la condition ternaire c'est parce que, comme on est en dehors du if on veut être sur que $_POST existe bien à ce niveau là
	}

	public function logout(){

		$auth = new AuthentificationModel();
		$auth->logUserOut();
		$this->redirectToRoute('login');
	}

	public function register(){

		if(!empty($_POST)){

			v::with("Validation\Rules"); // on informe Respect/Validation qu'on a fait des validateurs personnalisés pour qu il les récupère en indiquant son namespace

			$validators = array(

				'pseudo'=>v::length(3,50)->alnum()->noWhiteSpace()->usernameNotExists()->setName('Nom d\'utilisateur'),

				'email'=>v::emailNotExists()->setName('Email'),

				'mot_de_passe'=>v::length(3,50)->alnum()->noWhiteSpace()->setName('Mot de passe'),

				'avatar'=>v::optional(v::image()->size('0','1MB')->uploaded()),

				'sexe'=>v::in(['femme','homme','non-défini']),
				);

			$datas = $_POST;

			//on a une erreur à cause de l'avatar c normal car l'avatar ne fais pas partie de $_POST mais plutot de $_FILE. Donc on rajoute le chemin vers le fichier d'avatar qui a été uploadé si il existe. Si il existe il est tout d'abord stocké dans un répertoire temporaire tmp

			if(!empty($_FILES['avatar']['tmp_name'])){

				//Je stocke en données à valider le chemin vers la localisatiopn temporaire de l'avatar
				$datas['avatar'] = $_FILES['avatar']['tmp_name'];
			}else{

				//sinon je laisse le champ vide
				$datas['avatar'] = //realpath('avatars/default.png');
				'';
			}


			//je parcours la liste de mes validateurs en récupérant aussi le nom du champ en clé
			foreach($validators as $field =>$validator){

				// la méthode assert() renvoit une exception de type NestedValidationExcetion qui nous permet de récupérer le ou les messages d'erreur en cas d'erreur. 
				try{

					//on essaie de valider la donnée
					// si une exception se produit, c'est le blioc catch qui sera exécuté
					$validator->assert(isset($datas[$field]) ? $datas[$field] : '');

				} catch (NestedValidationException $ex) {

					$fullMessage = $ex->getFullMessage();
					$this->getFlashMessenger()->error($fullMessage);// ici on fait cohabiter nos 2 librairies
				}
				

			}

			if( ! $this->getFlashMessenger()->hasErrors()){

				//si on a pas rencontré d'erreurs on procède à l'insertion du nouvel utilisateur
				// mais avant de faire l'insertion on a 2 choses à faire: déplacer l'avatar du fichier temporaire vers une localisation permanente(dossier avatars) et on doit aussi hasher le password

				//hasage du mot de passe pour celà on utilise le model consacré AuthentificationModel() pour rester cohérent avec le framework
				$auth = new AuthentificationModel();
				$datas['mot_de_passe'] = $auth->hashPassword($datas['mot_de_passe']);

				if(!empty($_FILES['avatar']['tmp_name'])){

						//on déplace l'avatar vers le dossier avatars

						$initialAvatarPath = $_FILES['avatar']['tmp_name'];

						$avatarNewName = md5(time(). uniqid());

						$targetPath = realpath('assets/uploads/'); //realpath() fonction php a qui, lorsqu on donne le chemin relatif comme assets/ upload et  il reconstitue le chemin complet jusqu'au C

						move_uploaded_file($initialAvatarPath, $targetPath.'/'.$avatarNewName); // fonction PHP pour déplacer l'avatar 

						//on met à jour le nouveau nom de l'avatar dans $datas qui est celui qui est dans la localisation permanente il sera donc stocké sous ce nom final en BDD

						$datas['avatar'] = $avatarNewName;

				}else{

					$datas['avatar'] = 'default.png';
				}

				

				//insertion de l'utilisateur dans la BDD

				$utilisateursModel = new UtilisateursModel();

				unset($datas['send']);

				$userInfos = $utilisateursModel->insert($datas); // renvoit toutes les infos de l'utilisateur qu on insère en BDD y compris son id

				$auth->logUserIn($userInfos);//on connecte l'utilisateur

				$this->getFlashMessenger()->success("Votre inscription à T'Chat a bien été prise en compte");

				
				

				$this->redirectToRoute('default_home');




			}
		}

		$this->show('users/register');
	}

}