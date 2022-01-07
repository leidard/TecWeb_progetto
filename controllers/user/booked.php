<?php
require_once '../components/page.php';
require_once '../components/header.php';
require_once '../components/radio_book.php';
require_once '../components/breadcrumb.php';

$pagina = page('Prenotazioni');
$header = _header();
$main = file_get_contents('../../views/user/book.html');

require_once __DIR__ . '/../../services/user/book.php';
require_once __DIR__ . '/../../services/public/service.php';
require_once __DIR__ . '/../../services/public/staff.php';



$pagina = str_replace('%HEADER%', $header, $pagina);
$pagina = str_replace('%MAIN%', $main, $pagina);

echo $pagina;
