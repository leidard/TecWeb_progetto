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

	public function create($name, $surname, $sex)
	{
		$stmt = $this->prepare("INSERT INTO customer(name, surname, sex) VALUES (?,?,?)");
		if($sex == "Uomo")
			$sex = "M";
		else
			$sex = "F";
		
		$stmt->bind_param('sss', $name, $surname, $sex);
		if(!$stmt->execute())
		{
			throw($stmt->error);
		}	

		$stmt = $this->prepare("SELECT LAST_INSERT_ID()");
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_array();
		
		#$lastid = mysqli_insert_id($this>$conn);
		#return $lastid;

	}
}