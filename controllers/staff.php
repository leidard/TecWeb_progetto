<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/meta_index.php';

$pagina = page('Staff - Scissorhands');

$meta_index = _meta_index(true);
$pagina = str_replace('%META_INDEX%', $meta_index, $pagina);

$path = array(
    "Staff" => "/staff.php"
);

$header = _header($path);

$main = file_get_contents('../views/staff.html');

$pagina = str_replace('%DESCRIPTION%', "Lo staff è composto da barbieri e parrucchieri, che sapranno soddisfare le vostre richieste nei tagli e colori, grazie alla loro lunga esperienza." ,$pagina);
$pagina = str_replace('%KEYWORDS%', "staff, Edoardo Coppola, Padova, barbieria, barbiere, parrucchiere, tagli, colori",$pagina);
$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;