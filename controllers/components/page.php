<?php


function page($title) {
    $template = file_get_contents('../views/components/page.html');

    $out = str_replace('%TITLE%', $title, $template);

    // %HEADER%
    // %MAIN%
    // %FOOTER%
    
    return $out;
}