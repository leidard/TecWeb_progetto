<?php
require_once 'components/page.php';
require_once 'components/header.php';

require_once __DIR__ . '/../services/public/registration.php';

$pagina = page('Registrati - Scissorhands');

$path = array(
    "Registrati" => "/registrati.php"
);

$header = _header($path);
$footer = _footer();
$main = file_get_contents('../views/registrati.html');




if(isset($_GET["name"]) && isset($_GET["surname"]) && isset($_GET["sex"]) && isset($_GET["mail"]) && isset($_GET["password"]) && isset($_GET["password_rep"]))
{
	//if(filter_var($_GET["mail"], FILTER_VALIDATE_EMAIL)) # TODO Cambiare con una regex semplice, filter poterebbe dare problemi in loicale, mettere in relazione
	if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_GET["mail"]))
	{
		if($_GET["password_rep"] == $_GET["password"])
			RegistrationService::RegisterUser($_GET["name"], $_GET["surname"], $_GET["sex"], $_GET["mail"], $_GET["password"]);
		else
		{
			$main.="Le password non corrispondono.";
		}	
	}
	else
	{
		$main.="Email non valida."; #TODO Da riempire meglio ofc.
	}
}

$pagina = str_replace('%DESCRIPTION%', "Pagina di registrazione a Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "registrati, registrazione, iscrizione, scissorhands, barbiere, parrucchiere, barba, capelli, barbieria",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;

?>

