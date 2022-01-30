<?php

require_once __DIR__ . '/../../models/customer.php';

class CustomerService
{
	public static function getAll()
	{
        return (new Customer())->getAll();
	}

	public static function get($_id)
	{
        return (new Customer())->get($_id);
	}
}