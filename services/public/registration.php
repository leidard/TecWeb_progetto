<?php

#require_once __DIR__ . '../models/credential.php';
require_once __DIR__ . '/../../models/credential.php';
require_once __DIR__ . '/../../models/customer.php';

class RegistrationService
{
	public static function RegisterUser($name, $surname, $sex, $email, $password)
	{
		$ex = new Customer();
		$ex->create($name, $surname,  $sex, $email, password_hash($password,PASSWORD_BCRYPT)); #TESTARE
	}
}