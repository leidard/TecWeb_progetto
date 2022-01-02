<?php
require_once 'components/page.php';

$pagina = page('Errore di connessione - Scissorhands');
$main = file_get_contents('../views/errore_connessione.html');

// Questa pagina non deve essere indicizzata
$pagina = str_replace('%MAIN%', $main, $pagina);
$pagina = str_replace('%HEADER%', '', $pagina);
$pagina = str_replace('%DESCRIPTION%', '' ,$pagina);
$pagina = str_replace('%KEYWORDS%', '',$pagina);

echo $pagina;
?>