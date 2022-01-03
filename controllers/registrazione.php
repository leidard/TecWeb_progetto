<?php
require_once 'components/page.php';
require_once 'components/header.php';

$pagina = page('Registrazione - Scissorhands');
$path = array(
    "Home" => "/",
    "Registrazione" => "/registrazione.php"
);

$header = _header('Registrazione', $path);

$main = file_get_contents('../views/user/registrazione.html');

#CF, cognome, nome, data nascita

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;

?>

