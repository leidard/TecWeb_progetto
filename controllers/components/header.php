<?php
require_once __DIR__.'/menu.php';
require_once __DIR__.'/breadcrumb.php';

function _header(array $paths = []) {
    $template = file_get_contents(__DIR__.'/../../views/components/header.html');

    $out = $template;

    $menu = _menu();
    $out = str_replace('%NAVMENU%', $menu, $out);

    $breadcrumb = _breadcrumb($paths);
    $out = str_replace('%NAVBREADCRUMB%', $breadcrumb, $out);

    return $out;
}