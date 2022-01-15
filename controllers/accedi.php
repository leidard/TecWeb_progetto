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
	//header("Location: accedi.php");
	//die();

	echo "Gia loggato";
	echo $_SESSION["type"];
	$main = file_get_contents('../views/components/logout.html');
	if(isset($_GET["logout"]))
	{
		session_destroy();
	}
}
else
{
	$main = file_get_contents('../views/accedi.html');
	
	if(isset($_GET["mail"]) && preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_GET["mail"]))
	{
		$mail = $_GET["mail"];
	}
	else
	{
		unset($mail);
	}

	if(isset($_GET["password"]) && preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_GET["password"]))
	{
		$password = $_GET["password"];
	}
	else
	{
		unset($password);
	}
//TODO sistemare meglio sti if else

	if(isset($password) && isset($mail))
	{
		$password=PublicLoginService::getUserPassword($_GET["mail"]);
		if($password == $_GET["password"])
		{
			$_SESSION["sessionid"] = $_GET["mail"];
			if(Session::isUser($mail)) 
				$_SESSION["type"] = "USER";
			elseif(Session::isOwner($mail))
				$_SESSION["type"] = "OWNER";
			else	#better safe than sorry
				$_SESSION["type"] = "GUEST";

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
		// TODO redirect a ???
	}
	else
		echo "Dati non validi";
}

$header = _header($path);
$footer = _footer();

$pagina = str_replace('%DESCRIPTION%', "Pagina di accesso a Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "accedi, accesso, login, scissorhands, capelli, barba, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;

?>