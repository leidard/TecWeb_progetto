<?php

require_once __DIR__ . '/../../models/owner.php';

class OwnerService
{
	public static function getAll()
	{
        return (new Owner())->getAll();
	}

	public static function get($_id)
	{
        return (new Owner())->get($_id);
	}
}