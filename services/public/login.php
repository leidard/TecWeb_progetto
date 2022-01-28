<?php

require_once __DIR__.'/../../models/credential.php';

class PublicLoginService
{
	public static function getUserPassword($mail)
	{
		return (new Credential())->getUserPassword($mail);
	}

	public static function getUserId($mail)
	{
		return (new Credential())->getUserId($mail);
	}

	public static function verifyLogin($email, $userProvidedPassword)
	{
		$password = PublicLoginService::getUserPassword($email);
		if(empty($password))
			return false;
		return password_verify($userProvidedPassword,$password);
	}
}