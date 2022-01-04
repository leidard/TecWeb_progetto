<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/orari_apertura.php';

$pagina = page('Contatti - Scissorhands');

$path = array(
    "Home" => "/",
    "Contatti" => "/contatti.php"
);
$header = _header('Contatti', $path);

$main = file_get_contents('../views/contatti.html');

$orariApertura = orariApertura();
$main = str_replace('%ORARIAPERTURA%' , $orariApertura, $main);
$pagina = str_replace('%DESCRIPTION%', "I contatti e gli orari di Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "contatti, indirizzo, telefono, orari, scissorhands, barbieria",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;