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
		$ez->create($email, $password, "USER", $lastid); #For LAST_INSERT_ID(), the most recently generated ID is maintained in the server on a per-connection basis
	}
}