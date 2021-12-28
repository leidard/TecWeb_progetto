<?php

function breacrumb($els) {
    $template = file_get_contents(__DIR__.'/../../views/components/breadcrumb.html');

    $out = $template;

    $str = "";
    foreach ($els as $name => $ref) {
        if ($ref === $_SERVER['REQUEST_URI'])
            $str.= "<span>$name</span>";
        else
            $str.= "<a href=\"$ref\">$name</a>";
    }

    $out = str_replace("%BREADCRUMB_ELEMENTS%", $str, $out);
    
    return $out;
}


echo breacrumb(array(
    "Home" => "/",
    "Prenotazioni" => "/prenotazioni.php",
    "Prenotazioni" => "/components/breadcrumb.php"
));