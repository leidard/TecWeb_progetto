<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/orari_apertura.php';
require_once 'components/meta_index.php';

$pagina = page('Home - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$header = _header();

$main = file_get_contents('../views/index.html');

$orariApertura = orariApertura();
$main = str_replace('%ORARIAPERTURA%' , $orariApertura, $main);

$pagina = str_replace('%DESCRIPTION%', "Barbieria in centro a Padova e servizi di taglio per curare il proprio aspetto e rilassarsi." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "scissorhands, Padova, centro, barbiere, barbieria, parrucchiere, barba, capelli, orari, prenota",$pagina); 
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
?>