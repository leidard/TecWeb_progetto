<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/radio_book.php';
require_once 'components/meta_index.php';

$pagina = page('Prenota - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Prenota" => "/prenota.php"
);
$header = _header($path);
$main = file_get_contents('../views/prenota.html');

if(isset($_SESSION["type"]))
{
	if($_SESSION["type"] == "USER")
	{
		header("Location: /user/prenota.php");
		die();
	}
	else
	{
		header("Location: /staff/prenotazioni.php");
		die();
	}
}

$pagina = str_replace('%DESCRIPTION%', "Prenota un taglio di capelli o barba nella barbieria Scissorhands!" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "prenota, taglio, capelli, barba, scissorhands, barbiere, barbieria, parrucchiere",$pagina); 
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;