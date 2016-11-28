<?php

namespace Controller;

//use \W\Controller\Controller;
use Model\UtilisateursModel;

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

}