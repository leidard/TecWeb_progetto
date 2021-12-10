<?php


require_once 'components/page.php';
require_once 'components/footer.php';

$pagina = page('Home Page');

$footer = footer();

$pagina = str_replace('%FOOTER%', $footer, $pagina);

echo $pagina;
