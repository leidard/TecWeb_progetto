<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/radio_book.php';

$pagina = page('Prenota - Scissorhands');
$path = array(
    "Prenota" => "/prenota.php"
);
$header = _header($path);
$main = file_get_contents('../views/prenota.html');

$pagina = str_replace('%DESCRIPTION%', "Prenota un taglio di capelli o barba nella barbieria Scissorhands!" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "prenota, taglio, capelli, barba, scissorhands, barbiere, barbieria, parrucchiere",$pagina); 
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
