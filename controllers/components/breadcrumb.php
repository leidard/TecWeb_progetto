<?php

function _breadcrumb(array $paths) {
    $out = file_get_contents(__DIR__ . '/../../views/components/nav_breadcrumb.html');
    
    if (empty($paths))
        return str_replace("%BREADCRUMBS%", '<li><a class="current" lang="en" aria-current="location">Home</a></li>', $out);
    
    $str = '<li><a href="index.php" lang="en">Home</a></li>';
    $current = strtok($_SERVER["REQUEST_URI"], '?');
    $url_els = explode("/",$current);
    $current = $url_els[count($url_els)-1];

    foreach ($paths as $name => $ref) {
        if ($ref === $current) {
            $str .= "<li><a class=\"current\" aria-current=\"location\">$name</a></li>";
        } else {
            $str .= "<li><a href=\"$ref\">$name</a></li>";
        }
    }

    $out = str_replace("%BREADCRUMBS%", $str, $out);
    return $out;
}