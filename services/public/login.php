<?php

require_once __DIR__.'/../../models/credential.php';

class PublicLoginService
{
	public static function getUserCredentials($mail)
	{
		return (new Credential())->get($mail);
	}

	public static function getUserPassword($mail)
	{
		return (new Credential())->getUserPassword($mail)[0];
	}

	public static function verifyLogin($email, $userProvidedPassword)
	{
		$password = PublicLoginService::getUserPassword($email);
		return password_verify($userProvidedPassword,$password);
	}
}