<?php
require_once __DIR__.'/../../models/credential.php';

class UserPasswordChangeService 
{
	public static function changeUserPassword($mail, $password, $UserType)
	{
		(new Credential())->changeUserPassword($mail, password_hash($password, PASSWORD_BCRYPT), $UserType);
	}
    
}