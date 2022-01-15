<?php
require_once __DIR__.'/menu.php';
require_once __DIR__.'/breadcrumb.php';

function _header(array $paths = [], $dont_print_breadcrumb = false) {
    $template = file_get_contents(__DIR__.'/../../views/components/header.html');

    $out = $template;
	if(session_status() !== PHP_SESSION_ACTIVE)
		session_start();
	if(isset($_SESSION["type"]))
    	$menu = _menu($_SESSION["type"]);
	else
		$menu = _menu();
    $out = str_replace('%NAVMENU%', $menu, $out);

    if ($dont_print_breadcrumb) $breadcrumb = "";
    else $breadcrumb = _breadcrumb($paths);
    $out = str_replace('%NAVBREADCRUMB%', $breadcrumb, $out);

    return $out;
}