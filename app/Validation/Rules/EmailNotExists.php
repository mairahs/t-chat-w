<?php
namespace Validation\Rules;

/**
*Description of UsernameNotExists
*Cette classe sert à étendre les fonctionnalités de la bibliothèque respect/validation en y ajoutant un nouveau validateur

*/

use Respect\Validation\Rules\AbstractRule;
use W\Model\UsersModel;

class EmailNotExists extends AbstractRule
{
	public function validate($email){

		$userModel = new UsersModel(); //ou utilisateur Model
		return ! $userModel->emailExists($email);

	}
}