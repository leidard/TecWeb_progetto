<?php
require_once 'components/page.php';
require_once 'components/header.php';

require_once __DIR__ . '/../services/public/registration.php';

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


unset($name);
unset($surname);
unset($sex);
unset($mail);
unset($password);
unset($password_rep);

if(isset($_POST["submit"]) && isset($_POST["name"]) && !preg_match_all("/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/",$_POST["name"])) #TODO completare l'abominio
	$name = $_POST["name"];
else
{
	$_SESSION["regerror"] = "Caratteri invalidi nel nome o cognome";
	dontClearFields();
}

if(isset($_POST["submit"]) && isset($_POST["surname"]) && !preg_match_all("/[!@#$%^&*()\".,;:\-_+=<>1234567890\[\]\\|\{\}\/?]/",$_POST["surname"]))
	$surname = $_POST["surname"];
else
{
	$_SESSION["regerror"] = "Caratteri invalidi nel nome o cognome";
	dontClearFields();
}
	
if(isset($_POST["submit"]) && isset($_POST["sex"]) && ($_POST["sex"] == "Uomo" || $_POST["sex"] == "Donna" ))
	$sex = $_POST["sex"];
else
{
	$_SESSION["regerror"] = "Sesso non valido";
	dontClearFields();
}
	
if(isset($_POST["submit"]) && isset($_POST["mail"]) && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_POST["mail"]))
	$mail = $_POST["mail"];
else
{
	$_SESSION["regerror"] = "Formato mail non valido";
	dontClearFields();
}
	
if(isset($_POST["submit"]) && isset($_POST["password"]) && preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["password"]))
	$password = $_POST["password"];
else
{
	$_SESSION["regerror"] = "Formato password non valido";
	dontClearFields();
}	
if(isset($_POST["submit"]) && isset($_POST["password_rep"]) && preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["password_rep"]))
	$password_rep = $_POST["password_rep"];
else
{
	$_SESSION["regerror"] = "Formato ripeti password non valido";
	dontClearFields();
}



if(isset($_POST["submit"]) && isset($_SESSION["regerror"]))
{
	$main = str_replace("%ERRORE%",$_SESSION["regerror"], $main);
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
	$main = str_replace("%ERRORE%","", $main);
	$main = str_replace("%MAILP%","", $main);
	$main = str_replace("%NOMEP%","", $main);
	$main = str_replace("%COGNOMEP%","", $main);
	unset($_SESSION["mail"]);
	unset($_SESSION["name"]);
	unset($_SESSION["surname"]);
}







//if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["sex"]) && isset($_POST["mail"]) && isset($_POST["password"]) && isset($_POST["password_rep"]))
if(isset($_POST["submit"]) && isset($name) && isset($surname) && isset($sex) && isset($mail) && isset($password) && isset($password_rep))
{
	//if(filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) # TODO Cambiare con una regex semplice, filter poterebbe dare problemi in locale, mettere in relazione
	if($password_rep === $password)
		RegistrationService::RegisterUser($name, $surname, $sex, $mail, $password);
	else
	{
		#$main.="Le password non corrispondono.";
		$_SESSION["regerror"] = "Password non corrispondenti.";
		
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
/*
else
{
	$_SESSION["regerror"] = "Campi non compilati.";
}	
*/

$pagina = str_replace('%DESCRIPTION%', "Pagina di registrazione a Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "registrati, registrazione, iscrizione, scissorhands, barbiere, parrucchiere, barba, capelli, barbieria",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;

?>

