<?php

#require_once __DIR__ . '../models/credential.php';
require_once __DIR__ . '/../../models/credential.php';
require_once __DIR__ . '/../../models/customer.php';

class RegistrationService
{
	public static function RegisterUser($name, $surname, $sex, $email, $password)
	{
		$ex = new Customer();
		$lastid =$ex->create($name, $surname,  $sex)[0]; #TESTARE
		$ez = new Credential();
		$hashed = RegistrationService::hashPassword($password);
		$ez->create($email, $hashed, "USER", $lastid); #For LAST_INSERT_ID(), the most recently generated ID is maintained in the server on a per-connection basis
	}

	private static function hashPassword($password)
	{
		return password_hash($password,PASSWORD_BCRYPT);
	}
}