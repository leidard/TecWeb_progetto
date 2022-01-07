<?php
require_once __DIR__.'/../../models/credential.php';

class UserPasswordChangeService 
{
	public static function changeUserPassword($mail, $password)
	{
		(new Credential())->changeUserPassword($mail, $password);
	}
    
}