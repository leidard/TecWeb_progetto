<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Galleria - Scissorhands');
$header = _header('Galleria');

$main = file_get_contents('../views/galleria.html');


$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;