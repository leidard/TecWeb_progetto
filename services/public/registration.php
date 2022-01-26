<?php

#require_once __DIR__ . '../models/credential.php';
require_once __DIR__ . '/../../models/credential.php';
require_once __DIR__ . '/../../models/customer.php';

class RegistrationService
{
	public static function RegisterUser($name, $surname, $email, $password)
	{
		
		$ex = new Customer();
		if(!($ex->mailExists($email)))
		{
			$ex->create($name, $surname, $email, password_hash($password,PASSWORD_BCRYPT)); 
			return true;
		}
		else
			return false;

	}
}