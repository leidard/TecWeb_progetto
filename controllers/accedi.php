<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'components/meta_index.php';

require_once __DIR__ . '/../services/public/login.php';
require_once __DIR__ . '/../services/public/session.php';

$pagina = page('Accedi - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Accedi" => "accedi.php"
);

$main = file_get_contents('../views/accedi.html');

session_start();

$patternPassword = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{9,}/";

if(isset($_SESSION["sessionid"])) 
{
	header("Location: user_prenotazioni.php");
	die();
}

if(isset($_POST["submit"]) && isset($_POST["mail"]) && (preg_match("/^([a-z0-9\+_\-]{3,})(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]{3,}\.)[a-z]{2,6}$/ix", $_POST["mail"]) || $_POST["mail"]=="admin" || $_POST["mail"]=="user"))
{
	$mail = $_POST["mail"];
}
else
{
	$_SESSION["error"] = "<em><span role=alert id=\"accedi-errore\"> Email o password non corrette.</span></em>";
	if(isset($_POST["mail"]))
		$_SESSION["mail"] = $_POST["mail"];
	unset($mail);
}

if(isset($_POST["submit"]) && isset($_POST["password"]) && (preg_match($patternPassword, $_POST["password"]) || $_POST["password"]=="admin" || $_POST["password"]=="user"))
{
	$password = $_POST["password"];
}
else
{
	$_SESSION["error"] = "<em><span role=alert id=\"accedi-errore\"> Email o password non corrette.</span></em>";
	if(isset($_POST["mail"]))
		$_SESSION["mail"] = $_POST["mail"];
	unset($password);
}

if(isset($password) && isset($mail))
{
	if(PublicLoginService::verifyLogin($mail,$password))
	{
		$_SESSION["sessionid"] = PublicLoginService::getUserId($mail);
		$_SESSION["sessionmail"] = $mail;
		if(Session::isUser($mail)) 
		{
			$_SESSION["type"] = "USER";
			header("Location: user_prenotazioni.php");
			die();
		}
		elseif(Session::isOwner($mail))
		{
			$_SESSION["type"] = "OWNER";
			header("Location: staff_prenotazioni.php");
			die();
		}	
		else
		{
			$_SESSION["type"] = "GUEST";
			header("Location: logout.php"); 
		}
	}
	else
	{
		$_SESSION["error"]= "<em><span role=alert id=\"accedi-errore\"> Email o password non corrette.</span></em>";
		$_SESSION["mail"] = $mail;
	}
}

if(isset($_POST["submit"]) && isset($_SESSION["error"]))
{
	$main = str_replace("%ERRORE%",$_SESSION["error"], $main);
	unset($_SESSION["error"]);
	if(isset($_SESSION["mail"]))
		$main = str_replace("%MAILP%","value=\"".$_SESSION["mail"]."\"", $main);
	unset($_SESSION["mail"]);
}
else
{
	$main = str_replace("%ERRORE%", "", $main);
	$main = str_replace("%MAILP%", "", $main);
	unset($_SESSION["mail"]);
}

$header = _header($path);
$footer = _footer();

$pagina = str_replace('%DESCRIPTION%', "Accedi per prenotare subito il tuo prossimo taglio o sistemazione della barba." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "accedi, accesso, login, scissorhands, prenota, capelli, barba, barbiere, Padova",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;