<?php

namespace Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class UsernameNotExistsException extends ValidationException{

	public static $defaultTemplates = array(

		self::MODE_DEFAULT=>[

			'Le nom de l\'utilisateur existe déjà'

		],

		self::MODE_NEGATIVE =>[

			'Le nom de l\'utilisateur existe déjà'
		]



		);

}