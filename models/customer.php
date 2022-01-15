<?php
require_once __DIR__ . "/helper.php";

class Customer extends DBHelper {
	
	public function get($_id)
	{
		$stmt = $this->prepare("SELECT * FROM customer where _id = $_id LIMIT 1");
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

	public function create($name, $surname, $sex, $email, $password)
	{
		$stmt = $this->prepare("INSERT INTO customer(name, surname, sex, email, password) VALUES (?,?,?,?,?)");
		if($sex == "Uomo")
			$sex = "M";
		else
			$sex = "F";
		
		$stmt->bind_param('sssss', $name, $surname, $sex, $email, $password);
		if(!$stmt->execute())
		{
			throw($stmt->error);
		}	
				
		#$lastid = mysqli_insert_id($this>$conn);
		#return $lastid;
	}
}