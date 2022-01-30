<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/meta_index.php';

require_once __DIR__ . '/../services/public/registration.php';


if (session_status() === PHP_SESSION_NONE)
	session_start();

function dontClearFields()
{
	if(isset($_POST["name"]))
		$_SESSION["name"] = $_POST["name"];
	if(isset($_POST["surname"]))
		$_SESSION["surname"] = $_POST["surname"];
	if(isset($_POST["mail"]))
		$_SESSION["mail"] = $_POST["mail"];
}


if(isset($_SESSION["sessionid"])) #aka uno già loggato va qui 
{
	header("Location: user/prenotazioni.php");
	die();
}

$pagina = page('Registrati - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Registrati" => "/registrati.php"
);

$header = _header($path);
$footer = _footer();
$main = file_get_contents('../views/registrati.html');


unset($name);
unset($surname);
unset($mail);
unset($password);
unset($password_rep);

if(isset($_POST["submit"]) && isset($_POST["name"]) && !preg_match_all("/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/",$_POST["name"])) #TODO completare l'abominio
	$name = $_POST["name"];
elseif(isset($_POST["submit"]))
{
	$_SESSION["regerror"] = "<span id=\"reg-error\">Caratteri invalidi nel nome o cognome</span>";
	dontClearFields();
}

if(isset($_POST["submit"]) && isset($_POST["surname"]) && !preg_match_all("/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/",$_POST["surname"]))
	$surname = $_POST["surname"];
elseif(isset($_POST["submit"]))
{
	$_SESSION["regerror"] = "<span id=\"reg-error\">Caratteri invalidi nel nome o cognome</span>";
	dontClearFields();
}
	
if(isset($_POST["submit"]) && isset($_POST["mail"]) && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_POST["mail"]))
	$mail = $_POST["mail"];
elseif(isset($_POST["submit"]))
{
	$_SESSION["regerror"] = "<span id=\"reg-error\">Formato email non valido</span>";
	dontClearFields();
}
	
if(isset($_POST["submit"]) && isset($_POST["password"]) && preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["password"]))
	$password = $_POST["password"];
elseif(isset($_POST["submit"]))
{
	$_SESSION["regerror"] = "<span id=\"reg-error\">Formato password non valido</span>";
	dontClearFields();
}

if(isset($_POST["submit"]) && isset($_POST["password_rep"]) && preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["password_rep"]))
	$password_rep = $_POST["password_rep"];
elseif(isset($_POST["submit"]))
{
	$_SESSION["regerror"] = "<span id=\"reg-error\">Formato ripeti password non valido</span>";
	dontClearFields();
}



#if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["mail"]) && isset($_POST["password"]) && isset($_POST["password_rep"]))
if(isset($_POST["submit"]) && isset($name) && isset($surname) && isset($mail) && isset($password) && isset($password_rep))
{
	#if(filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) # TODO Cambiare con una regex semplice, filter poterebbe dare problemi in locale, mettere in relazione
	if($password_rep === $password)
	{
		$ex = RegistrationService::RegisterUser($name, $surname, strtolower($mail), $password);
		if($ex)
		{
			$_SESSION["regcomplete"] = "<span id=\"reg-complete\">Registrazione completata! <a href=\"/accedi.php\">Clicca qui per effettuare l'accesso<a></span>.";
			#unset everything??????????????
		}
		else
		{
			$_SESSION["regerror"] = "<span id=\"reg-error\">Email già utilizzata</span>";
		}
	}
	else
	{
		$_SESSION["regerror"] = "<span id=\"reg-error\">Password non corrispondenti.</span>";
		
		unset($mail);
		unset($name);
		unset($surname);
	}	

	//Salvataggio campi in caso JS non vadi
	if(isset($_SESSION["regerror"]))
	{
		if(isset($mail))
			$_SESSION["mail"] = $mail;
		if(isset($name))
			$_SESSION["name"] = $name;
		if(isset($surname))
			$_SESSION["surname"] = $surname;
		
	}

}


if(isset($_POST["submit"]) && isset($_SESSION["regerror"]))
{
	$main = str_replace("%MESSAGGIO%",$_SESSION["regerror"], $main);
	unset($_SESSION["regerror"]);

	//Salvataggio campi in caso JS non vadi
	if(isset($_SESSION["mail"]))
		$main = str_replace("%MAILP%","value=\"".$_SESSION["mail"]."\"", $main);
	if(isset($_SESSION["name"]))
		$main = str_replace("%NOMEP%","value=\"".$_SESSION["name"]."\"",$main);
	if(isset($_SESSION["surname"]))
		$main = str_replace("%COGNOMEP%","value=\"".$_SESSION["surname"]."\"",$main);

	#unset($mail);
	#unset($name);
	#unset($surname);
	unset($_SESSION["mail"]);
	unset($_SESSION["name"]);
	unset($_SESSION["surname"]);


}
else
{
	
	if(isset($_POST["submit"]) && isset($_SESSION["regcomplete"]))
		$main = str_replace("%MESSAGGIO%",$_SESSION["regcomplete"], $main);
	else
		$main = str_replace("%MESSAGGIO%","", $main);
	$main = str_replace("%MAILP%","", $main);
	$main = str_replace("%NOMEP%","", $main);
	$main = str_replace("%COGNOMEP%","", $main);
	unset($_SESSION["mail"]);
	unset($_SESSION["name"]);
	unset($_SESSION["surname"]);
}


/*
else
{
	$_SESSION["regerror"] = "Campi non compilati.";
}	
*/

$pagina = str_replace('%DESCRIPTION%', "Registrati subito a Scissorhands per prenotare!" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "registrati, registrazione, iscrizione, scissorhands, barbiere, parrucchiere, barba, capelli, barbieria, Padova",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;

?>

