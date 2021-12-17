<?php


function footer() {
    $template = file_get_contents(__DIR__.'/../../views/components/footer.html');

    // $out = str_replace('%TITOLO%', "World", $template);
    $out = $template;
    
    return $out;
}