<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/orari_apertura.php';
require_once 'components/meta_index.php';

$pagina = page('Contatti - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Contatti" => "/contatti.php"
);
$header = _header($path);

$main = file_get_contents('../views/contatti.html');

$orariApertura = orariApertura();
$main = str_replace('%ORARIAPERTURA%' , $orariApertura, $main);
$pagina = str_replace('%DESCRIPTION%', "Come contattarci e come raggiungerci." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "contatti, indirizzo, mappa, telefono, orari, mail, scissorhands, barbieria, Padova, centro Padova",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;