<?php

require_once __DIR__.'/../../models/credential.php';

class Session {
	public static function isUser($mail)
	{
		return ((new Credential())->isUser($mail));
	}

	public static function isOwner($mail)
	{
		return (new Credential())->isOwner($mail);	
	}
}
