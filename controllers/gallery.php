<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'components/breadcrumb.php';


$pagina = page('Gallery - Scissorhands');

$header = _header();

$breadcrumb = _breadcrumb(array(
    "Home" => "/index.php",
    "Gallery" => "/"
));

$main = file_get_contents('../views/gallery.html');

/**
 * Vari str_replace nella vista main
 */
$header = str_replace('%TITOLO%', 'Gallery', $header);



$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%BREADCRUMB%', $breadcrumb, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);


echo $pagina;
?>