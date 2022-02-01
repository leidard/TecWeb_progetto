<?php
require_once __DIR__ . "/helper.php";

class Customer extends DBHelper {
	
	public function get($_id)
	{
		$stmt = $this->prepare("SELECT * FROM customer where _id = ? LIMIT 1");
		$stmt->bind_param('s', $_id);
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_assoc();
	}

	public function getAll()
	{
		$stmt = $this->prepare("SELECT * FROM customer");
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_assoc();
	}

	public function mailExists($mail)
	{
		$stmt = $this->prepare("SELECT EXISTS(select * FROM customer where email=?)");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_array()[0];
	}

	public function create($name, $surname, $email, $password)
	{
		$stmt = $this->prepare("INSERT INTO customer(name, surname, email, password) VALUES (?,?,?,?)");
		
		
		$stmt->bind_param('ssss', $name, $surname, $email, $password);
		if(!$stmt->execute())
		{
			throw($stmt->error);
		}	
	}
}