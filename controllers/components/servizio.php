<?php

function servizio($nome, $durata = '', $prezzo = '') {
    $out = file_get_contents(__DIR__.'/../../views/components/servizio.html');

    $out = str_replace('%NOME_SERVIZIO%', $nome, $out);
    $out = str_replace('%DURATA_SERVIZIO%', $durata, $out);
    $out = str_replace('%PREZZO_SERVIZIO%', $prezzo, $out);

    return $out;
}