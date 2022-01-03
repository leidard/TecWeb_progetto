<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Galleria - Scissorhands');

$path = array(
    "Home" => "/",
    "Galleria" => "/galleria.php"
);
$header = _header('Galleria', $path);

$main = file_get_contents('../views/galleria.html');

$pagina = str_replace('%DESCRIPTION%', "Scopri l'esperienza nei servizi che troverai in Scissorhands grazie alle nostre foto" ,$pagina);
$pagina = str_replace('%KEYWORDS%', 'gallery, scissorhands, foto, barbiere, parrucchiere, barba, capelli',$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;