<?php


function footer() {
    $template = file_get_contents('../views/components/footer.html');

    // $out = str_replace('%TITOLO%', "World", $template);
    $out = $template;
    
    return $out;
}