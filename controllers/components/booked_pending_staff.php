<?php


function booked_pending_staff($_id, $start_at, $end_at, $service, $staff, $price, $c_name, $c_surname) {
    $out = file_get_contents(__DIR__ . '/../../views/components/booked_pending_staff.html');

    $day = gmdate('d F Y', $start_at);
    $from = gmdate('G:i', $start_at);
    $to = gmdate("G:i", $end_at);
    $duration = floor(($end_at - $start_at) / 60);

    $out = str_replace("%ID%", $_id, $out);
    $out = str_replace("%DAY%", $day, $out);
    $out = str_replace("%HOUR_START%", $from, $out);
    $out = str_replace("%DURATION%", $duration, $out);
    $out = str_replace("%SERVICE%", $service, $out);
    $out = str_replace("%STAFF%", $staff, $out);
    $out = str_replace("%PRICE%", $price, $out);
    $out = str_replace("%CUSTOMER%", $c_name . " " . $c_surname, $out);

    return $out;
}
