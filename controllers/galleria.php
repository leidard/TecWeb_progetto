<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/meta_index.php';

$pagina = page('Galleria - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Galleria" => "/galleria.php"
);
$header = _header($path);

$main = file_get_contents('../views/galleria.html');

$pagina = str_replace('%DESCRIPTION%', "Foto dei nostri lavori e del negozio." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "galleria, foto, tagli, capelli, barba, acconciature, tinte, scissorhands, barbiere, parrucchiere",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;