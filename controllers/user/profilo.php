<?php
require_once '../components/page.php';
require_once '../components/header.php';
require_once '../components/footer.php';
require_once '../components/meta_index.php';

require_once __DIR__ . '/../../services/public/login.php';
require_once __DIR__ . '/../../services/public/session.php';
require_once __DIR__ . '/../../services/user/change_password.php';
require_once __DIR__ . '/../../services/user/customer.php';
require_once __DIR__ . '/../../services/staff/owner.php';


$pagina = page('Profilo - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Profilo" => "/user/profilo.php"
);


if (session_status() === PHP_SESSION_NONE)
	session_start();

if(!isset($_SESSION["sessionid"])) {
	header("Location: /accedi.php");
	die();
}

$header = _header($path);
$footer = _footer();



if(isset($_POST["submit"]) && isset($_POST["new_password"]) && (preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["new_password"]) || $_POST["new_password"]=="admin" || $_POST["new_password"]=="user"))
	$newPassword = $_POST["new_password"];
else
{
	$_SESSION["message"] = "Caratteri non validi nella nuova password";
}

if(isset($_POST["submit"]) && isset($_POST["confirm_new_password"]) && (preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["confirm_new_password"]) || $_POST["confirm_new_password"]=="admin" || $_POST["confirm_new_password"]=="user"))
	$confirmnewPassword = $_POST["confirm_new_password"];
else
{
	$_SESSION["message"] = "Caratteri non validi nella Conferma della nuova password";
}
	

if(isset($_POST["submit"]) && isset($_POST["current_password"]) && (preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["current_password"]) || $_POST["current_password"]=="admin" || $_POST["current_password"]=="user"))
	$currentPassword = $_POST["current_password"];
else
{
	$_SESSION["message"] = "Caratteri non validi nella password corrente";
}
	

$main = file_get_contents('../../views/user/pagina_personale.html');
if(isset($_POST["submit"]) && isset($currentPassword) && isset($newPassword) && isset($confirmnewPassword))
{
	#change password
	$currentPassword = PublicLoginService::getUserPassword($_SESSION["sessionmail"]);
	//if($currentPassword == $_POST["current_password"])
	if(PublicLoginService::verifyLogin($_SESSION["sessionmail"], $_POST["current_password"]))
	{
		if($newPassword==$confirmnewPassword)
		{
			UserPasswordChangeService::changeUserPassword($_SESSION["sessionmail"], $newPassword, $_SESSION["type"]);
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

if(isset($_POST["submit"]) && isset($_SESSION["message"]))
{
	$main = str_replace("%MESSAGGIO%",$_SESSION["message"], $main);
	unset($_SESSION["message"]);
}
else
	$main = str_replace("%MESSAGGIO%", "", $main);

if($_SESSION["type"] == "OWNER")
{
	$main = str_replace("%NOME%", OwnerService::get($_SESSION["sessionid"])["name"], $main);
	$main = str_replace("%COGNOME%", OwnerService::get($_SESSION["sessionid"])["surname"], $main);
	$main = str_replace("%MAIL%", OwnerService::get($_SESSION["sessionid"])["email"], $main);
}
else
{
	$main = str_replace("%NOME%", CustomerService::get($_SESSION["sessionid"])["name"], $main);
	$main = str_replace("%COGNOME%", CustomerService::get($_SESSION["sessionid"])["surname"], $main);
	$main = str_replace("%MAIL%", CustomerService::get($_SESSION["sessionid"])["email"], $main);
}

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;
