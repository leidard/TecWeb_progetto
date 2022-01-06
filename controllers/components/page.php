<?php
require_once __DIR__.'/footer.php';

function page($title) {
    $template = file_get_contents(__DIR__.'/../../views/components/page.html');

    $out = $template;
    
    $out = str_replace('%TITLE%', $title, $out);
    
    $footer = _footer();
    $out = str_replace('%FOOTER%', $footer, $out);
    
    return $out;
}