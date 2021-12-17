<?php

function _header() {
    $template = file_get_contents(__DIR__.'/../../views/components/header.html');

    // $out = str_replace('%TITOLO%', "World", $template);
    $out = $template;
    
    return $out;
}