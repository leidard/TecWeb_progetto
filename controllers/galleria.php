<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Galleria - Scissorhands');

$path = array(
    "Home" => "/",
    "Galleria" => "../galleria.php"
);
$header = _header('Galleria', $path);

$main = file_get_contents('../views/galleria.html');

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;