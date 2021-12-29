<?php
require_once __DIR__ . "/helper.php";

class Credential extends DBHelper {

#    public static function get() {
#        return array(
#            "email" => "admin",
#            "password" => "admin",
#        );
#    }

	public function get($cf)
	{
		$stmt = $this->prepare("SELECT * FROM credentials where customer_ref = ? OR owner_ref = ? LIMIT 1");
		$stmt->bind_param('ss', $cf, $cf);
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_assoc();
	}

	public function create($cf, $email, $password, $type)  
	{
		if(strcmp($type, "USER" ))
		{	
			$stmt = $this->prepare("INSERT INTO credential(email, password, type, customer_ref, owner_ref) VALUES (?,?,?,?,NULL)");
			$stmt->bind_param("ssss",$email, $password, $type, $cf);
		}
		else #type == admin
		{	
			$stmt = $this->prepare("INSERT INTO credential(email, password, type, customer_ref, owner_ref) VALUES (?,?,?,NULL,?)");
			$stmt->bind_param("ssss",$email, $password, $type, $cf);
		}
		$stmt->execute();
	}	
}

 