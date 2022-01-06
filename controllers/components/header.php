<?php
require_once 'components/menu.php';
require_once 'components/breadcrumb.php';

function _header($currentPage, $path) {
    $template = file_get_contents(__DIR__.'/../../views/components/header.html');
    $pagesNames = array ('Home','Servizi','Staff','Galleria','Contatti','Prenota','Accedi','Registrati');

    $out = $template;

    //menu
    $template = file_get_contents(__DIR__.'/../../views/components/nav_menu.html');
    $out = str_replace('%NAVMENU%', $template, $out);
    $menu = _menu($currentPage,$pagesNames);
    $out = str_replace("%MENU%",$menu,$out);

    //breadcrumb
    if(empty($path))
        $out = str_replace('%NAVBREADCRUMB%', '',$out);
    else
    {
        $template = file_get_contents(__DIR__.'/../../views/components/nav_breadcrumb.html');
        $out = str_replace('%NAVBREADCRUMB%', $template, $out);
        $breadcrumb = _breadcrumb($path);
        $out = str_replace("%BREADCRUMB%",$breadcrumb,$out);
    }
    

    return $out;
}