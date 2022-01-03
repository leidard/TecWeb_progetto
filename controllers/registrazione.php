<?php
require_once 'components/page.php';
require_once 'components/header.php';

require_once __DIR__ . '/../services/public/registration.php';

$pagina = page('Registrazione - Scissorhands');

$path = array(
    "Home" => "/",
    "Registrazione" => "registrazione.php"
);

$header = _header('Registrazione',$path);
$footer = _footer();
$main = file_get_contents('../views/user/registrazione.html');




if(isset($_GET["name"]) && isset($_GET["surname"]) && isset($_GET["sex"]) && isset($_GET["mail"]) && isset($_GET["password"]))
{
	if(filter_var($_GET["mail"], FILTER_VALIDATE_EMAIL)) # Da considerare i falsi positivi/negativi
	{
		RegistrationService::RegisterUser($_GET["name"], $_GET["surname"], $_GET["sex"], $_GET["mail"], $_GET["password"]);
	}
	else
	{
		$main.="Email non valida."; # Da riempire meglio ofc.
	}
}


$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;

?>

