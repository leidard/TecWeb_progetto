<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Servizi - Scissorhands');

$path = array(
    "Home" => "/",
    "Servizi" => "/servizi.php"
);
$header = _header('Servizi', $path);

$main = file_get_contents('../views/servizi.html');

$pagina = str_replace('%DESCRIPTION%', "I servizi di Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "servizi, capelli, barba, forbici, lama a mano libera, macchinetta, anallergici, ecosostenibili, scissorhands, barbiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
