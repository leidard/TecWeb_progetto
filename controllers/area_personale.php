<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/footer.php';

require_once __DIR__ . '/../services/public/login.php';
require_once __DIR__ . '/../services/public/session.php';
require_once __DIR__ . '/../services/user/change_password.php';

$pagina = page('Area personale - Scissorhands');
$path = array(
    "Area Personale" => "/area_personale.php"
);
$header = _header($path);
$footer = _footer();


session_start();

if(isset($_SESSION["sessionid"]))
{

	if(isset($_GET["current_password"]) && preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_GET["current_password"]))
		$currentPassword = $_GET["current_password"];
	if(isset($_GET["new_password"]) && preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_GET["new_password"]))
		$newPassword = $_GET["new_password"];
	
	if(isset($_GET["confirm_new_password"]) && preg_grep("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_GET["confirm_new_password"]))
		$confirmnewPassword = $_GET["confirm_new_password"];

	$main = file_get_contents('../views/user/pagina_personale.html');
	if(isset($currentPassword) && isset($newPassword) && isset($confirmnewPassword))
	{
		#change password
		$currentPassword = PublicLoginService::getUserPassword($_SESSION["sessionid"]);
		//if($currentPassword == $_GET["current_password"])
		if(PublicLoginService::verifyLogin($_SESSION["sessionid"], $_GET["current_password"]))
		{
			if($newPassword==$confirmnewPassword)
			{
				UserPasswordChangeService::changeUserPassword($_SESSION["sessionid"], $newPassword, $_SESSION["type"]);
				echo "password cambiata";
			}
			else
			{
				echo "password nuova non corrispondono";
			}
		}
		else
		{
			echo "Password corrente non corrisponde";
		}
	}
}
else
{
	header("Location: accedi.php");
	die();
}


#$main = file_get_contents('../views/accedi.html');

$pagina = str_replace('%DESCRIPTION%', "Area personale" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "scissorhands, capelli, barba, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;

?>

