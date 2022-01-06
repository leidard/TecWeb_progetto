<?php

function _footer() {
    $template = file_get_contents(__DIR__.'/../../views/components/footer.html');
    $out = $template;
    
    return $out;
}