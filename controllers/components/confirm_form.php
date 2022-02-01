<?php

function confirm_form($selected_service, $selected_staff, $selected_day, $slots) {
    $main = file_get_contents('../../views/components/confirm_form.html');
    
    $radios_slot = "";
    foreach ($slots as $slot) {
        $s = $slot["start"];
        $radios_slot .= radio_book(date("H:i", $s) . "-" . date("H:i", $slot["end"]), "time", $s, $s, false, false);
    }

    $main = str_replace("%RADIOS_SLOT%", $radios_slot, $main);
    $main = str_replace("%SELECTED_SERVICE%", $selected_service, $main);
    $main = str_replace("%SELECTED_STAFF%", $selected_staff, $main);
    $main = str_replace("%SELECTED_DAY%", $selected_day, $main);
    return $main;
}