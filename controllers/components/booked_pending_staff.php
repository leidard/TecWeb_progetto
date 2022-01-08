<?php


function booked_pending_staff($_id, $start_at, $end_at, $service, $staff, $confirmed) {
    $out = file_get_contents(__DIR__.'/../../views/components/booked_pending_staff.html');

    $day = gmdate('d m Y', $start_at);
    $from = gmdate('G:i', $start_at);
    $to = gmdate("G:i", $end_at);
    $duration = floor(($end_at-$start_at) / 60);

    $out = str_replace("%ID%", $_id, $out);
    $out = str_replace("%DAY%", $day, $out);
    $out = str_replace("%HOUR_START%", $from, $out);
    $out = str_replace("%HOUR_END%", $to, $out);
    $out = str_replace("%DURATION%", $duration, $out);
    $out = str_replace("%SERVICE%", $service, $out);

    return $out;
}
