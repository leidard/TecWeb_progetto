<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/servizio.php';

$pagina = page('Listino barba - Scissorhands');
$header = _header('Listino barba');

$main = file_get_contents('../views/listino_barba.html');


$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);



echo $pagina;