<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('404: Pagina non trovata - Scissorhands');
$main = file_get_contents('../views/404.html');


$header = _header([], true);
$pagina = str_replace('%MAIN%', $main, $pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%DESCRIPTION%', '' ,$pagina);
$pagina = str_replace('%KEYWORDS%', '',$pagina);

echo $pagina;
?>