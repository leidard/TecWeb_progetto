<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Errore di connessione - Scissorhands');
$main = file_get_contents('../views/errore_connessione.html');

$header = _header([], true);
$pagina = str_replace('%MAIN%', $main, $pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%DESCRIPTION%', '' ,$pagina);
$pagina = str_replace('%KEYWORDS%', '',$pagina);

echo $pagina;
?>