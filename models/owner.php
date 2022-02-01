<?php

class Owner extends DBHelper{

	public function get($_id)
	{
		$stmt = $this->prepare("SELECT * FROM owner where _id = ? LIMIT 1");
		$stmt->bind_param('s', $_id);
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_assoc();
	}

    public function getAll()
	{
		$stmt = $this->prepare("SELECT * FROM owner");
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_assoc();
	}
}