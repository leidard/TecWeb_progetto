<?php

require_once __DIR__.'../../models/credential.php';
require_once __DIR__.'../../models/customer.php';

class RegistrationService
{
	public static function RegisterUser($cf, $name, $surname, $date_of_birth, $sex, $email, $password)
	{
		$ex = new Customer();
		$ex->create($cf, $name, $surname, $date_of_birth, $sex);
		$ez = new Credential();
		$ez->create($cf, $email, $password, $type);
	}
}