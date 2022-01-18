<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/footer.php';

require_once __DIR__ . '/../services/public/login.php';
require_once __DIR__ . '/../services/public/session.php';
require_once __DIR__ . '/../services/user/change_password.php';

$pagina = page('Profilo - Scissorhands');
$path = array(
    "Profilo" => "/profilo.php"
);


session_start();

$header = _header($path);
$footer = _footer();




if(isset($_SESSION["sessionid"]))
{
	if(isset($_POST["current_password"]) && (preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["current_password"]) || $_POST["current_password"]=="admin" || $_POST["current_password"]=="user"))
		$currentPassword = $_POST["current_password"];
	if(isset($_POST["new_password"]) && (preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["new_password"]) || $_POST["new_password"]=="admin" || $_POST["new_password"]=="user"))
		$newPassword = $_POST["new_password"];
	
	if(isset($_POST["confirm_new_password"]) && (preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["confirm_new_password"]) || $_POST["confirm_new_password"]=="admin" || $_POST["confirm_new_password"]=="user"))
		$confirmnewPassword = $_POST["confirm_new_password"];

	$main = file_get_contents('../views/user/pagina_personale.html');
	if(isset($currentPassword) && isset($newPassword) && isset($confirmnewPassword))
	{
		#change password
		$currentPassword = PublicLoginService::getUserPassword($_SESSION["sessionid"]);
		//if($currentPassword == $_POST["current_password"])
		if(PublicLoginService::verifyLogin($_SESSION["sessionid"], $_POST["current_password"]))
		{
			if($newPassword==$confirmnewPassword)
			{
				UserPasswordChangeService::changeUserPassword($_SESSION["sessionid"], $newPassword, $_SESSION["type"]);
				$_SESSION["message"] = "Password cambiata!";
			}
			else
			{
				$_SESSION["message"] = "Le password nuove non corrispondono";
			}
		}
		else
		{
			$_SESSION["message"] = "Password corrente errata";
		}
	}
}
else
{
	header("Location: accedi.php");
	die();
}

if(isset($_SESSION["message"]))
{
	$main = str_replace("%MESSAGGIO%",$_SESSION["message"], $main);
	unset($_SESSION["message"]);
}
else
	$main = str_replace("%MESSAGGIO%", "", $main);


#$main = file_get_contents('../views/accedi.html');

$pagina = str_replace('%DESCRIPTION%', "Profilo" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "scissorhands, capelli, barba, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;

?>

