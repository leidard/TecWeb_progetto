<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/orari_apertura.php';

$pagina = page('Home - Scissorhands');

$path = array(
    "Home" => "/home.php"
    );
$header = _header('Home', $path);

$main = file_get_contents('../views/home.html');

/**
 * Vari str_replace nella vista main
 */
$orariApertura = orariApertura();
$main = str_replace('%ORARIAPERTURA%' , $orariApertura, $main);

$pagina = str_replace('%DESCRIPTION%', "Barbieria a Padova e servizi di taglio per curare il proprio look e rilassarsi" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "scissorhands, barbiere, parrucchiere, barba, capelli, barbieria, orari",$pagina); // norme covid?
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;
?>