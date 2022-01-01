<?php
require_once 'components/menu.php';
require_once 'components/breadcrumb.php';

function _header($currentPage, $path) {
    $template = file_get_contents(__DIR__.'/../../views/components/header.html');

    $out = $template;

    $menu = _menu($currentPage);
    $breadcrumb = _breadcrumb($path);

    $out = str_replace("%MENU%",$menu,$out);
    $out = str_replace("%BREADCRUMB%",$breadcrumb,$out);

    return $out;
}