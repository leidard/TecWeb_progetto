<?php
require_once 'components/page.php';
require_once 'components/header.php';
//require_once 'components/servizio.php';

$pagina = page('Servizi - Scissorhands');

$header = _header('Servizi');

$main = file_get_contents('../views/servizi.html');

/*
Sta cosa va usata nei listini
$lista_servizi = '';
$lista_servizi .= servizio("Taglio");
$lista_servizi .= servizio("Colore");
$lista_servizi .= servizio("Lavaggio");

$main = str_replace('%LISTA_SERVIZI%', $lista_servizi, $main);
*/

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
