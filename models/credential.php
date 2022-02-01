<?php
require_once __DIR__ . "/helper.php";

class Credential extends DBHelper {

#    public static function get() {
#        return array(
#            "email" => "admin",
#            "password" => "admin",
#        );
#    }

	/*public function get($mail)
	{
		$stmt = $this->prepare("SELECT * FROM credential where email=? LIMIT 1");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_assoc();
	}*/

	public function getUserPassword($mail)
	{
		$stmt = $this->prepare("SELECT password FROM owner where email=?");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		if(mysqli_num_rows($res) != 0)
		{
			$var = $res->fetch_array()[0];
			if(!empty($var))
				return $var;
		}

		$stmt = $this->prepare("SELECT password FROM customer where email=?");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		if(mysqli_num_rows($res) != 0)
		{	
			$var = $res->fetch_assoc()["password"];
			if(!empty($var))
				return $var;
		}
		return NULL;
	}

	public function getUserId($mail)
	{
		$stmt = $this->prepare("SELECT _id FROM owner where email=?");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		if(mysqli_num_rows($res) != 0)
		{
			$var = $res->fetch_array()[0];
			if(!empty($var))
				return $var;
		}

		$stmt = $this->prepare("SELECT _id FROM customer where email=?");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		if(mysqli_num_rows($res) != 0)
		{	
			$var = $res->fetch_array()[0];
			if(!empty($var))
				return $var;
		}
		return NULL;
	}

	public function changeUserPassword($mail, $password, $UserType)
	{
		if($UserType == "OWNER")
			$stmt = $this->prepare("UPDATE owner SET password=? where email=?");
		elseif($UserType == "USER")
			$stmt = $this->prepare("UPDATE customer SET password=? where email=?");
		else
			return; //non dovrebbe essere possibile arrivare qui
		$stmt->bind_param('ss', $password, $mail);
		$stmt->execute();
	}
	
	public function isUser($mail)
	{
		$stmt = $this->prepare("SELECT EXISTS(select * FROM customer where email=?)");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_array()[0];
	}

	public function isOwner($mail)
	{
		$stmt = $this->prepare("SELECT EXISTS(select * FROM owner where email=?)");
		$stmt->bind_param('s', $mail);
		$stmt->execute();
		$res = $stmt->get_result();
		return $res->fetch_array()[0];
	}
}

 