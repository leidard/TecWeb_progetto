<?php
require_once __DIR__.'/footer.php';

function page($title) {
    $template = file_get_contents(__DIR__.'/../../views/components/page.html');

    $out = $template;
    
    // set title
    $out = str_replace('%TITLE%', $title, $out);
    
    $footer = footer();
    // set footer
    $out = str_replace('%FOOTER%', $footer, $out);
    
    return $out;
}