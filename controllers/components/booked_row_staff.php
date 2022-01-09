<?php


function booked_row_staff($id, $start_at, $end_at, $service, $staff, $customer) {
    $out = file_get_contents(__DIR__ . '/../../views/components/booked_row_staff.html');

    $from = gmdate('G:i', $start_at);
    $to = gmdate("G:i", $end_at);
    $duration = floor(($end_at-$start_at) / 60);

    $out = str_replace("%ID%", $id, $out);
    $out = str_replace("%HOUR_START%", $from, $out);
    $out = str_replace("%HOUR_END%", $to, $out);
    $out = str_replace("%DURATION%", $duration, $out);
    $out = str_replace("%SERVICE%", $service, $out);
    $out = str_replace("%STAFF%", $staff, $out);
    $out = str_replace("%CUSTOMER%", $customer, $out);

    return $out;
}