<?php
require_once __DIR__ . "/helper.php";

class Credential extends DBHelper {

#    public static function get() {
#        return array(
#            "email" => "admin",
#            "password" => "admin",
#        );
#    }

	public function get($mail)
	{
		$stmt = $this->prepare("SELECT * FROM credential where email=? LIMIT 1");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_assoc();
	}

	public function getUserPassword($mail)
	{
		$stmt = $this->prepare("SELECT password FROM credential where  email=? LIMIT 1");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_array();
	}

	public function changeUserPassword($mail, $password)
	{
		$stmt = $this->prepare("UPDATE credential SET password=? where email=?");
		$stmt->bind_param('ss', $password, $mail);
		$stmt->execute();
	}

	public function create($email, $password, $type, $_id)  
	{
		if(strcmp($type, "USER" ))
		{	
			$stmt = $this->prepare("INSERT INTO credential(email, password, type, customer_ref) VALUES (?,?,?,?)");
			$stmt->bind_param("ssss",$email, $password, $type, $_id);
		}
		else #type == admin
		{	
			$stmt = $this->prepare("INSERT INTO credential(email, password, type, owner_ref) VALUES (?,?,?,?)");
			$stmt->bind_param("ssss",$email, $password, $type, $_id);
		}
		$stmt->execute();
	}

	public function isUser($mail)
	{
		$stmt = $this->prepare("SELECT type FROM credential where email=? LIMIT 1");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		if($res->fetch_array()[0] == "USER")
			return true;
		return false;
	}
}

 