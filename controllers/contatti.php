<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Contatti - Scissorhands');

$path = array(
    "Home" => "/",
    "Contatti" => "/contatti.php"
);
$header = _header('Contatti', $path);

$main = file_get_contents('../views/contatti.html');

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;