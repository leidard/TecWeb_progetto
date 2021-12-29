<?php

function radio_book($label, $name, $value, $id, bool $checked) {
    $template = file_get_contents(__DIR__.'/../../views/components/radio_book.html');

    $out = $template;

    $out = str_replace('%RADIO_BOOK_ID%', $id, $out);
    $out = str_replace('%RADIO_BOOK_NAME%', $name, $out);
    $out = str_replace('%RADIO_BOOK_LABEL%', $label, $out);
    $out = str_replace('%RADIO_BOOK_VALUE%', $value, $out);
    $out = str_replace("%RADIO_BOOK_CHECKED%", $checked, $out);
    
    return $out;
}