<?php

namespace Controller;

//use \W\Controller\Controller;
use Model\SalonsModel;
use Model\MessagesModel;


class SalonController extends BaseController
{

	/*
	*cette action permet de voir la liste des messages d'un salon
	*@param int $id l'id du salon dont je cherche à voir les messages
	*/
	public function seeSalon($id){

		// On instancie le modèle des salons de façon à récupérer les informations du salon dont l'id est $id (passé dans l'URL)
		$salonsModel = new SalonsModel();
		$salon = $salonsModel -> find($id);



		// On instancie le modèle des messages maintenant pour récupérer les messages du salon dont l'id est $id donc on veut tous les messages d'un salon dont l'id est $id il y a une méthode générique qui existe pour ça search()

		//le contenu du comm précédent n'est plus actuel vu qu on a changé la méthode: J'utilise une méthode propre au modèle MessagesModel qui permet de récupérer les messages avec les infos utilisateurs associées	

		$messagesModel = new MessagesModel();

		if(!empty($_POST)){

			if(!empty($_POST['corps'])){

				if($this->getUser()){

					$datas = ['corps'=>$_POST['corps'], 'date_creation'=>date('Y-m-d H:i:s'), 'date_modification'=>date('Y-m-d H:i:s'), 'id_utilisateur'=>$this->getUser()['id'], 'id_salon'=>$id ];
					$messagesModel->insert($datas);
				}else{

						$this->getFlashMessenger()->error('Vous devez être connecté pour poster un message');

				}

			}else{

				$this->getFlashMessenger()->error('Veuillez renseigner un message à poster');
			}
		}


		//SELECT * FROM messages WHERE id_salon = $id
		//$messages = $messagesModel ->search(array('id_salon' =>$id), 'OR', FALSE);

		$messages = $messagesModel ->searchAllWithUserInfos($id);


		//  J'utilise la méthode search() qui me permet donc d'exécuter la requete suivante: SELECT * FROM messages WHERE id_salon = $id. Cette méthode me renvoit l'équivalent d'un fetchAll() c'est à dire un tableau de tableau (multidimensionnel)

		$this->show('salons/see', array('salon' => $salon, 'messages' =>$messages));
	}

	public function newMessages($idSalon,$idMessage){
		//on va améliorer la fonction searchAllWithUserInfo() qui fait ce qu'on veut en lui rajoutant des param optionnele
		$messagesModel = new MessagesModel();

		$messages = $messagesModel->searchAllWithUserInfos($idSalon,$idMessage);
		$this->show('salons/newmessages', array('messages' =>$messages));
	}

}