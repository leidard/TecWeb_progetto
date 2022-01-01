<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Staff - Scissorhands');
$header = _header('Staff');

$main = file_get_contents('../views/lo_staff.html');

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
