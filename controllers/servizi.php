<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/footer.php';
require_once 'components/servizio.php';

$pagina = page('Servizi');

$header = _header();
$footer = footer();
$main = file_get_contents('../views/servizi.html');

$lista_servizi = '';
$lista_servizi .= servizio("Taglio");
$lista_servizi .= servizio("Colore");
$lista_servizi .= servizio("Lavaggio");

/**
 * Vari str_replace nella vista main
 */
$main = str_replace('%LISTA_SERVIZI%', $lista_servizi, $main);


$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%FOOTER%', $footer, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
