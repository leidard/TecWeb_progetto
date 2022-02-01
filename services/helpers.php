<?php

function getDayOfWeek(int $time) {
    return (floor($time / 86400) + 3) % 7;
}

function parseDaysSet(string $days) {
    $arr = explode(',', $days);
    return [
        in_array('MON', $arr),
        in_array('TUE', $arr),
        in_array('WED', $arr),
        in_array('THU', $arr),
        in_array('FRI', $arr),
        in_array('SAT', $arr),
        in_array('SUN', $arr),
    ];

    date("H:i", time());
}

function encodeDayArray(array $days) {
    $str = [];
    if ($days[0]) array_push($str, "MON");
    if ($days[1]) array_push($str, "TUE");
    if ($days[2]) array_push($str, "WED");
    if ($days[3]) array_push($str, "THU");
    if ($days[4]) array_push($str, "FRI");
    if ($days[5]) array_push($str, "SAT");
    if ($days[6]) array_push($str, "SUN");

    return implode(",", $str);
}

function getDayOfWeekSTR(int $time) {
    switch (getDayOfWeek($time)) {
        case 0:
            return "Lunedì";
        case 1:
            return "Martedì";
        case 2:
            return "Mercoledì";
        case 3:
            return "Giovedì";
        case 4:
            return "Venerdì";
        case 5:
            return "Sabato";
        case 6:
            return "Domenica";
    }
}

function floorDay(int $time) {
    return $time - ($time % 86400);
}