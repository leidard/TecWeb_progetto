<?php

setlocale(LC_TIME, 'it_IT');

function booked_pending($start_at, $end_at, $service, $price, $staff, $id) {
    $out = file_get_contents(__DIR__ . '/../../views/components/booked_pending.html');

    $day = date('d/m/Y', $start_at);
    $from = date('G:i', $start_at);
    $duration = ($end_at - $start_at) / 60;

    $out = str_replace("%ID%", $id, $out);
    $out = str_replace("%DAY%", $day, $out);
    $out = str_replace("%HOUR%", $from, $out);
    $out = str_replace("%DURATION%", $duration, $out);
    $out = str_replace("%SERVICE%", $service, $out);
    $out = str_replace("%PRICE%", number_format($price, 2, ",", " "), $out);
    $out = str_replace("%STAFF%", $staff, $out);

    return $out;
}