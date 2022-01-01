<?php
require_once 'components/menu.php';
require_once 'components/breadcrumb.php';

function _header($currentPage) {
    $template = file_get_contents(__DIR__.'/../../views/components/header.html');

    $out = $template;

    $menu = _menu($currentPage);
    //$breadcrumb = _breadcrumb(...);
    $out = str_replace("%MENU%",$out,$menu);
    //$out = str_replace("%BREADCRUMB%",$out,$breadcrumb);

    return $out;
}