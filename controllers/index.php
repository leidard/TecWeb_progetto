<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/footer.php';

$pagina = page('Home Page');

$header = _header();

$main = file_get_contents('../views/index.html');

/**
 * Vari str_replace nella vista main
 */
$main = str_replace('%TITOLO%', "123", $main);


$pagina = str_replace('%HEADER%', $header, $pagina);

$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
