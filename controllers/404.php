<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/meta_index.php';

$pagina = page('404: Pagina non trovata - Scissorhands');

$meta_index = _meta_index(false);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$main = file_get_contents('../views/404.html');


$header = _header([], true);
$pagina = str_replace('%MAIN%', $main, $pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);

echo $pagina;
?>