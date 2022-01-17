<?php
require_once 'components/page.php';
require_once 'components/header.php';

require_once __DIR__ . '/../services/public/registration.php';

session_start();
if(isset($_SESSION["sessionid"])) #aka uno già loggato va qui #TODO da migliorare la situazione quando uno è già loggato?
{
	header("Location: user/prenotazioni.php");
	die();
}



$pagina = page('Registrati - Scissorhands');

$path = array(
    "Registrati" => "/registrati.php"
);

$header = _header($path);
$footer = _footer();
$main = file_get_contents('../views/registrati.html');

if(isset($_SESSION["error"]))
{
	$main = str_replace("%ERRORE%",$_SESSION["error"], $main);
	unset($_SESSION["error"]);
}
else
{
	$main = str_replace("%ERRORE%","", $main);
}

unset($name);
unset($surname);
unset($sex);
unset($mail);
unset($password);
unset($password_rep);

if(isset($_GET["name"]) && !preg_match_all("/[!@#$%^&*()'\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/",$_GET["name"])) #TODO completare l'abominio
	$name = $_GET["name"];
if(isset($_GET["surname"]) && !preg_match_all("/[!@#$%^&*()'\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/",$_GET["surname"]))
	$surname = $_GET["surname"];
if(isset($_GET["sex"]) && ($_GET["sex"] === "Uomo" || $_GET["sex"] === "Donna" ))
	$sex = $_GET["sex"];
if(isset($_GET["mail"]) && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_GET["mail"]))
	$mail = $_GET["mail"];
if(isset($_GET["password"]) && preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_GET["password"]))
	$password = $_GET["password"];
if(isset($_GET["password_rep"]) && preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_GET["password_rep"]))
	$password_rep = $_GET["password_rep"];


//if(isset($_GET["name"]) && isset($_GET["surname"]) && isset($_GET["sex"]) && isset($_GET["mail"]) && isset($_GET["password"]) && isset($_GET["password_rep"]))
if(isset($name) && isset($surname) && isset($sex) && isset($mail) && isset($password) && isset($password_rep))
{
	//if(filter_var($_GET["mail"], FILTER_VALIDATE_EMAIL)) # TODO Cambiare con una regex semplice, filter poterebbe dare problemi in locale, mettere in relazione
	if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $mail)) #TODO ridondante (vedi regex sopra)
	{
		if($password_rep === $password)
			RegistrationService::RegisterUser($name, $surname, $sex, $mail, $password);
		else
		{
			#$main.="Le password non corrispondono.";
			#TODO trovare un modo di non resettare i field

			$_SESSION["error"] = "Password non corrispondenti.";
		}	
	}
	else
	{
		$_SESSION["error"] = "Email non valida."; #TODO Da riempire meglio ofc.
	}
}
/*
else
{
	$_SESSION["error"] = "Campi non compilati.";
}	
*/

$pagina = str_replace('%DESCRIPTION%', "Pagina di registrazione a Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "registrati, registrazione, iscrizione, scissorhands, barbiere, parrucchiere, barba, capelli, barbieria",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;

?>

