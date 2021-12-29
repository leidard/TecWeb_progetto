<?php
require_once 'components/page.php';
require_once 'components/header.php';
require_once 'components/footer.php';

$pagina = page('Registrazione');
$header = _header();
$footer = footer();
$main = file_get_contents('../views/user/registrazione.html');

#CF, cognome, nome, data nascita

$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%FOOTER%', $footer, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;

?>

