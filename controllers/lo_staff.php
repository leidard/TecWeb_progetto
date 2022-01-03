<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Staff - Scissorhands');
$path = array(
    "Home" => "/",
    "Staff" => "/lo_staff.php"
);

$header = _header('Staff', $path);

$main = file_get_contents('../views/lo_staff.html');

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
