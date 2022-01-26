<?php

function _servizio($nome, $prezzo, $durata = '', $descrizione = '') {
    $out = file_get_contents(__DIR__.'/../../views/components/servizio.html');
    $out = str_replace('%NOME%', $nome, $out);
    $out = str_replace('%PREZZO%', number_format($prezzo, 2, ",", " "), $out);
    $out = str_replace('%DURATA%', $durata/60, $out); //(?)
    $out = str_replace('%DESCRIZIONE%', $descrizione, $out);

    return $out;
}

