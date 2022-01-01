<?php
require_once 'components/menu.php';

function _header($currentPage) {
    $template = file_get_contents(__DIR__.'/../../views/components/header.html');

    // $out = str_replace('%TITOLO%', "World", $template);
    $out = $template;
    $menu = _menu($currentPage);
    $out = str_replace("%MENU%",$out,$menu);
    return $out;
}