<?php
require_once __DIR__ . "/helper.php";

class Customer extends DBHelper {
	
	public function get($cf)
	{
		$stmt = $this->prepare("SELECT * FROM customer where cf = $cf LIMIT 1");
		$stmt->bind_param('s', $cf);
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

	public function create($cf, $name, $surname, $date_of_birth, $sex)
	{
		$stmt = $this->prepare("INSERT INTO customer(cf, name, surname, date_of_birth, sex) VALUES (?,?,?,?,?)");
		$stmt->bind_param('sssss', $cf); #CONTROLLARE che la data sia inserita correttamente, non è menzionato nei doc se deve essere considerata 's' o altro
		$stmt->execute();
	}
}