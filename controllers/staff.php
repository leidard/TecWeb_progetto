<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Staff - Scissorhands');
$path = array(
    "Home" => "/home.php",
    "Staff" => "/staff.php"
);

$header = _header('Staff', $path);

$main = file_get_contents('../views/staff.html');

$pagina = str_replace('%DESCRIPTION%', "Lo staff di Scissorhands" ,$pagina);
$pagina = str_replace('%KEYWORDS%', "staff, Edoardo Coppola, Roberto Fortuna, Alice Valli, barbieria, barbiere, parrucchiere, scissorhands",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
