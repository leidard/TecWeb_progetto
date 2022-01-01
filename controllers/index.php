<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/breadcrumb.php';
require_once 'components/orari_apertura.php';

$pagina = page('Home Page');

$header = _header('Home');

$breadcrumb = _breadcrumb(array(
    "Home" => "/",
    "Gallery" => "/gallery.php"
));

$main = file_get_contents('../views/index.html');

/**
 * Vari str_replace nella vista main
 */
$header = str_replace('%TITOLO%', 'Scissorhands', $header);
$orariApertura = orariApertura();
$main = str_replace('%ORARIAPERTURA%' , $orariApertura, $main);



$pagina = str_replace('%HEADER%', $header, $pagina);
//$pagina = str_replace('%BREADCRUMB%', $breadcrumb, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;
?>