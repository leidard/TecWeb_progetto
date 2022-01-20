<?php

#require_once __DIR__ . '../models/credential.php';
require_once __DIR__ . '/../../models/credential.php';
require_once __DIR__ . '/../../models/customer.php';

class RegistrationService
{
	public static function RegisterUser($name, $surname, $sex, $email, $password)
	{
		
		$ex = new Customer();
		if(!($ex->mailExists($email)))
		{
			$ex->create($name, $surname,  $sex, $email, password_hash($password,PASSWORD_BCRYPT)); #TESTARE
			return true;
		}
		else
			return false;

	}
}