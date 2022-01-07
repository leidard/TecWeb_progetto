<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/footer.php';

require_once __DIR__ . '/../services/public/login.php';
require_once __DIR__ . '/../services/public/session.php';
require_once __DIR__ . '/../services/user/change_password.php';

$pagina = page('Area Personale - Scissorhands');
$path = array(
    "Area Personale" => "/area_personale.php"
);
$header = _header($path);
$footer = _footer();


session_start();

if(isset($_SESSION["sessionid"]))
{
	$main = file_get_contents('../views/user/pagina_personale.html');
	if(isset($_GET["current_password"]) && isset($_GET["new_password"]) && isset($_GET["confirm_new_password"]))
	{
		#change password
		$currentPassword = PublicLoginService::getUserPassword($_SESSION["sessionid"]);
		if($currentPassword == $_GET["current_password"])
		{
			if($_GET["new_password"]==$_GET["confirm_new_password"])
			{
				UserPasswordChangeService::changeUserPassword($_SESSION["sessionid"], $_GET["new_password"]);
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
	echo "non loggato"; #TODO fare redirecta a login
}


#$main = file_get_contents('../views/accedi.html');

$pagina = str_replace('%DESCRIPTION%', "Area personale" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "scissorhands, capelli, barba, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;

?>

