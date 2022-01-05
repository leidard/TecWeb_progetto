<?php
require_once 'components/page.php';
require_once 'components/header.php';

require_once __DIR__ . '/../services/public/registration.php';

$pagina = page('Registrazione - Scissorhands');

$path = array(
    "Home" => "/",
    "Registrazione" => "/registrazione.php"
);

$header = _header('Registrazione',$path);
$footer = _footer();
$main = file_get_contents('../views/registrazione.html');




if(isset($_GET["name"]) && isset($_GET["surname"]) && isset($_GET["sex"]) && isset($_GET["mail"]) && isset($_GET["password"]) && isset($_GET["password_rep"]))
{
	if(filter_var($_GET["mail"], FILTER_VALIDATE_EMAIL)) # Da considerare i falsi positivi/negativi
	{
		if($_GET["password_rep"] == $_GET["password"])
			RegistrationService::RegisterUser($_GET["name"], $_GET["surname"], $_GET["sex"], $_GET["mail"], $_GET["password"]);
		else
		{
			$main.="Le password non corrispondo.";
		}	
	}
	else
	{
		$main.="Email non valida."; # Da riempire meglio ofc.
	}
}

$pagina = str_replace('%DESCRIPTION%', "Pagina di registrazione a Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "registrazione, iscrizione, scissorhands, barbiere, parrucchiere, barba, capelli, barbieria",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;

?>

