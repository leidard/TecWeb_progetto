<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/radio_book.php';

$pagina = page('Prenota - Scissorhands');
$header = _header();
$main = file_get_contents('../views/prenota.html');

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
