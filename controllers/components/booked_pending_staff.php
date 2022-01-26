<?php

setlocale(LC_TIME, 'it_IT');

function booked_pending_staff($_id, $start_at, $end_at, $service, $staff, $price, $c_name, $c_surname) {
    $out = file_get_contents(__DIR__ . '/../../views/components/booked_pending_staff.html');

    $day = date('d F Y', $start_at);
    $from = date('G:i', $start_at);
    $to = date("G:i", $end_at);
    $duration = floor(($end_at - $start_at) / 60);

    $out = str_replace("%ID%", $_id, $out);
    $out = str_replace("%DAY%", $day, $out);
    $out = str_replace("%HOUR_START%", $from, $out);
    $out = str_replace("%DURATION%", $duration, $out);
    $out = str_replace("%SERVICE%", $service, $out);
    $out = str_replace("%STAFF%", $staff, $out);
    $out = str_replace("%PRICE%", number_format($price, 2, ",", " "), $out);
    $out = str_replace("%CUSTOMER%", $c_name . " " . $c_surname, $out);

    return $out;
}
