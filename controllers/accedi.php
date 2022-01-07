<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/footer.php';

require_once __DIR__ . '/../services/public/login.php';
require_once __DIR__ . '/../services/public/session.php';

$pagina = page('Accedi - Scissorhands');

$path = array(
    "Accedi" => "/accedi.php"
);

session_start();

if(isset($_SESSION["sessionid"])) #TODO da migliorare la situazione quando uno è già loggato
{
	echo "Gia loggato";
	$main = file_get_contents('../views/components/logout.html');
	if(isset($_GET["logout"]))
	{
		session_destroy();
	}
}
else
{
	$main = file_get_contents('../views/accedi.html');
	
	if(isset($_GET["mail"]) && isset($_GET["password"]))
	{
		$password=PublicLoginService::getUserPassword($_GET["mail"]);
		if($password == $_GET["password"])
		{
			$_SESSION["sessionid"] = $_GET["mail"];
		}
		else
		{
			echo "Dati errati";
		}
		/*
			if(PublicLoginService::verifyLogin($_GET["mail"],$_GET["password"]))
			{
				$_SESSION["sessionid"] = $_GET["mail"];
			}
			else
			{
				echo "Dati errati";
			}
		
			*/

		echo $password;
		echo  $_GET["password"];
	}
}

$header = _header($path);
$footer = _footer();

$pagina = str_replace('%DESCRIPTION%', "Pagina di accesso a Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "accedi, accesso, login, scissorhands, capelli, barba, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;

?>