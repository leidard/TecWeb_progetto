<?php

function _breadcrumb(array $paths) {
    $out = file_get_contents(__DIR__ . '/../../views/components/nav_breadcrumb.html');
    
    if (empty($paths))
        return str_replace("%BREADCRUMBS%", '<li><a class="current" href="/" lang="en" aria-current="location">Home</a></li>', $out);
    
    $str = '<li><a href="/" lang="en">Home</a></li>';
    $current = strtok($_SERVER["REQUEST_URI"], '?');
    foreach ($paths as $name => $ref) {
        if ($ref === $current) {
            $str .= "<li><a class=\"current\" aria-current=\"location\" href=\"$ref\">$name</a></li>";
        } else {
            $str .= "<li><a href=\"$ref\">$name</a></li>";
        }
    }

    $out = str_replace("%BREADCRUMBS%", $str, $out);
    return $out;
}
