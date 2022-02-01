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

if($_SESSION["type"] == "OWNER")
{
	header("Location /staff/orari.php");
	die();
}

$header = _header($path);
$footer = _footer();
$patternPassword = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{9,}/";

if(isset($_POST["submit"]) && isset($_POST["confirm_new_password"]) && (preg_match($patternPassword, $_POST["confirm_new_password"]) || $_POST["confirm_new_password"]=="admin" || $_POST["confirm_new_password"]=="user"))
	$confirmnewPassword = $_POST["confirm_new_password"];
else
{
	$_SESSION["message"] = "<em><span role=\"alert\" id=\"cpw-error\">Caratteri non validi in conferma nuova password.</span></em>";
}

if(isset($_POST["submit"]) && isset($_POST["new_password"]) && (preg_match($patternPassword, $_POST["new_password"]) || $_POST["new_password"]=="admin" || $_POST["new_password"]=="user"))
	$newPassword = $_POST["new_password"];
else
{
	$_SESSION["message"] = "<em><span role=\"alert\" id=\"cpw-error\">Caratteri non validi in nuova password o requisiti non rispettati.</span></em>";
}	

if(isset($_POST["submit"]) && isset($_POST["current_password"]) && (preg_match($patternPassword, $_POST["current_password"]) || $_POST["current_password"]=="admin" || $_POST["current_password"]=="user"))
	$currentPassword = $_POST["current_password"];
else
{
	$_SESSION["message"] = "<em><span role=\"alert\" id=\"cpw-error\">La password attuale non è corretta.</span></em>";
}
	

$main = file_get_contents('../../views/user/pagina_personale.html');
if(isset($_POST["submit"]) && isset($currentPassword) && isset($newPassword) && isset($confirmnewPassword))
{
	$currentPassword = PublicLoginService::getUserPassword($_SESSION["sessionmail"]);
	if(PublicLoginService::verifyLogin($_SESSION["sessionmail"], $_POST["current_password"]))
	{
		if($newPassword==$confirmnewPassword)
		{
			UserPasswordChangeService::changeUserPassword($_SESSION["sessionmail"], $newPassword, $_SESSION["type"]);
			$_SESSION["message"] = "<em><span role=\"alert\" id=\"cpw-success\">Password aggiornata!</span></em>";
		}
		else
		{
			$_SESSION["message"] = "<em><span role=\"alert\" id=\"cpw-error\">Password nuove non corrispondenti.</span></em>";
		}
	}
	else
	{
		$_SESSION["message"] = "<em><span role=\"alert\" id=\"cpw-error\">Password attuale errata.</span></em>";
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
	$var = OwnerService::get($_SESSION["sessionid"]);
	$main = str_replace("%NOME%", $var["name"], $main);
	$main = str_replace("%COGNOME%", $var["surname"], $main);
	$main = str_replace("%MAIL%", $var["email"], $main);
}
else
{
	$var = CustomerService::get($_SESSION["sessionid"]);
	$main = str_replace("%NOME%", $var["name"], $main);
	$main = str_replace("%COGNOME%", $var["surname"], $main);
	$main = str_replace("%MAIL%", $var["email"], $main);
}

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;
